<?php
/*
Plugin Name: data4WoMo - Daten für mein Wohnmobil
Plugin URI: https://www.roger-zueger.ch
Description: Ein WordPress-Plugin, das bestimmte Werte und Parameter aus einer zentralen MySQL Datenbank ausliest, welche zuvor dort von verschiedenen Tools & Programmen gespeichert wurden.
Version: 1.0
Author: Züger, Roger
Author URI: https://www.roger-zueger.ch
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: data4WoMo
*/

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'Direct access is not allowed!' );

// Aktiviere die Verwendung von Optionen
add_action('admin_init', 'data4WoMo_register_settings');
add_action('admin_menu', 'data4WoMo_add_admin_menu');

// Registriere die zu speichernden Parameter in Wordpress
function data4WoMo_register_settings() {
    // Registriere die notwendigen Option für das Plugin
    register_setting('data4WoMo_options', 'data4WoMo_db_host');    
    register_setting('data4WoMo_options', 'data4WoMo_db_name');
    register_setting('data4WoMo_options', 'data4WoMo_db_passwd');
    register_setting('data4WoMo_options', 'data4WoMo_db_user');
}

function data4WoMo_add_admin_menu() {
    // Füge ein Menü in den Adminbereich hinzu
    add_options_page('data4WoMo Einstellungen', 'data4WoMo Einstellungen', 'manage_options', 'data4WoMo-plugin', 'data4WoMo_options_page');
}


function data4WoMo_options_page() {
    // Erstelle die Einstellungsseite
    ?>
<div class="wrap">
    <h1>data4WoMo-Plugin Einstellungen</h1>
    <form method="post" action="options.php">
        <?php settings_fields('data4WoMo_options'); ?>
        <?php do_settings_sections('data4WoMo_options'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Server</th>
                <th scope="row">Datenbankname</th>
                <th scope="row">Benutzername</th>
                <th scope="row">Passwort</th>
            </tr>
            <tr valign="top">
                <td><input type="text" name="data4WoMo_db_host"
                        value="<?php echo esc_attr(get_option('data4WoMo_db_host')); ?>" /></td>
                <td><input type="text" name="data4WoMo_db_name"
                        value="<?php echo esc_attr(get_option('data4WoMo_db_name')); ?>" /></td>
                <td><input type="text" name="data4WoMo_db_user"
                        value="<?php echo esc_attr(get_option('data4WoMo_db_user')); ?>" /></td>
                <td><input type="text" name="data4WoMo_db_passwd"
                        value="<?php echo esc_attr(get_option('data4WoMo_db_passwd')); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
    <h1>Erlaubte Shortcodes und Funktionen des Plugins</h1>
    <div style="margin-top: 20px; margin-bottom: 10px;">
        <h3>Syntax</h3>
        <p>[data4WoMo_Value <i>[Parameter]</i>="<i>[Wert]]</i>"]</p>
        <table border="1" spacing="5">
            <tr>
                <th valign="top" width="200px">Shortcode</th>
                <th valign="top">Beschrieb</th>
            </tr>
            <tr>
                <td valign="top">
                    <h3>data4WoMo</h3>
                </td>
                <td valign="top">
                    <b>value</b> - Liefert einen (berechneten) Wert anhand des Parameters <b>value</b> aus der
                    Datenbank zurück. Mögliche Werte für den Parameter sind:<br>
                    <ul>
                        <li><b><i>aktuell_altitude_max</i></b>: Höchst gemessener Punkt gemäss GPS auf der aktuellen
                            Route</li>
                        <li><b><i>aktuell_altitude_min</i></b>: Tiefster gemessener Punkt gemäss GPS auf der aktuellen
                            Route</li>
                        <li><b><i>aktuell_strecke</i></b>: Total zurückgelegte Strecke in km gemäss internem GPS der
                            aktuellen Route</li>
                        <li><b><i>aktuell_trackpoints</i></b>: Anzahl aufgezeichneter Trackpoints (GPS Punkte) der
                            aktuellen Route</li>
                        <li><b><i>aktuell_speed_max</i></b>: Höchst gemessene Geschwindigkeit gemäss GPS auf der
                            aktuellen Route</li>
                        <li><b><i>aktuell_gefaelle_total</i></b>: Total aller Gefälle (in Meter) gemäss GPS/Höhendaten
                            Google auf der aktuellen Route</li>
                        <li><b><i>aktuell_steigung_total</i></b>: Total aller Steigungen (in Meter) gemäss
                            GPS/Höhendaten auf der aktuellen Route</li>
                        <li><b><i>aktuell_ort</i></b>: Aktueller Ort (Standort) gemäss GPS und Google Geolocation
                            Dienst<br></li>
                        <li><b><i>aktuell_land</i></b>: Aktuelles Land (Standort) gemäss GPS und Google Geolocation
                            Dienst</li>
                    </ul>
                    <ul>
                        <li><b><i>total_altitude_max</i></b>: Höchst gemessener Punkt gemäss GPS aller
                            aufgezeichneten Routen</li>
                        <li><b><i>total_altitude_min</i></b>: Tiefster gemessener Punkt gemäss GPS aller
                            aufgezeichneten Routen</li>
                        <li><b><i>total_strecke</i></b>: Total zurückgelegte Strecke in km gemäss internem GPS
                            aller aufgezeichneten Routen</li>
                        <li><b><i>total_trackpoints</i></b>: Anzahl aufgezeichneter Trackpoints (GPS Punkte)
                            aller aufgezeichneten Routen</li>
                        <li><b><i>total_speed_max</i></b>: Höchst gemessene Geschwindigkeit gemäss GPS auf der
                            allen aufgezeichneten Routen</li>
                        <li><b><i>total_gefaelle_total</i></b>: Total aller Gefälle (in Meter) gemäss
                            GPS/Höhendaten Google auf allen aufgezeichneten Routen</li>
                        <li><b><i>total_steigung_total</i></b>: Total aller Steigungen (in Meter) gemäss
                            GPS/Höhendaten Google auf allen aufgezeichneten Routen</li>
                    </ul>
                    <ul>
                        <li><b><i>temperatur_aussen</i></b>: Zuletzt gemessene Aussentemperatur (wird ca.
                            alle 5-10min aktualisiert)</li>
                        <li><b><i>min_temperatur_aussen</i></b>: Minimal gemessene Aussentemperatur auf
                            allen aufgezeichneten Routen</li>
                        <li><b><i>max_temperatur_aussen</i></b>: Maximal gemessene Aussentemperatur auf
                            allen aufgezeichneten Routen</li>
                        <li><b><i>aktuell_min_temperatur_aussen</i></b>: Minimal gemessene Aussentemperatur
                            auf aktuell aufgezeichneter Route</li>
                        <li><b><i>aktuell_max_temperatur_aussen</i></b>: Maximal gemessene Aussentemperatur
                            auf aktuell aufgezeichneter Route</li>
                        <li><b><i>luftfeuchtigkeit_aussen</i></b>: Zuletzt gemessene Luftfeuchtigkeit aussen
                            (wird ca. alle 5-10min aktualisiert)</li>
                        <li><b><i>min_luftfeuchtigkeit_aussen</i></b>: Minimal gemessene
                            Aussenluftfeuchtigkeit auf allen aufgezeichneten Routen</li>
                        <li><b><i>max_luftfeuchtigkeit_aussen</i></b>: Maximal gemessene
                            Aussenluftfeuchtigkeit auf allen aufgezeichneten Routen</li>
                        <li><b><i>aktuell_min_luftfeuchtigkeit_aussen</i></b>: Minimal gemessene
                            Aussenluftfeuchtigkeit auf aktuell aufgezeichneter Route</li>
                        <li><b><i>aktuell_max_luftfeuchtigkeit_aussen</i></b>: Maximal gemessene
                            Aussenluftfeuchtigkeit auf aktuell aufgezeichneter Route</li>
                        <li><b><i>temperatur_innen</i></b>: Zuletzt gemessene Innenraumtemperatur (wird ca.
                            alle 5-10min aktualisiert)</li>
                        <li><b><i>min_temperatur_innen</i></b>: Minimal gemessene Innenraumtemperatur auf
                            allen aufgezeichneten Routen</li>
                        <li><b><i>max_temperatur_innen</i></b>: Maximal gemessene Innenraumtemperatur auf
                            allen aufgezeichneten Routen</li>
                        <li><b><i>aktuell_min_temperatur_innen</i></b>: Minimal gemessene
                            Innenraumtemperatur auf aktuell aufgezeichneter Route</li>
                        <li><b><i>aktuell_max_temperatur_innen</i></b>: Maximal gemessene
                            Innenraumtemperatur auf aktuell aufgezeichneter Route</li>
                        <li><b><i>luftfeuchtigkeit_innen</i></b>: Zuletzt gemessene Luftfeuchtigkeit im
                            Innenraum (wird ca. alle 5-10min aktualisiert)</li>
                        <li><b><i>min_luftfeuchtigkeit_innen</i></b>: Minimal gemessene
                            Innenraumluftfeuchtigkeit auf allen aufgezeichneten Routen</li>
                        <li><b><i>max_luftfeuchtigkeit_innen</i></b>: Minimal gemessene
                            Innenraumluftfeuchtigkeit auf allen aufgezeichneten Routen</li>
                        <li><b><i>aktuell_min_luftfeuchtigkeit_innen</i></b>: Minimal gemessene
                            Innenraumluftfeuchtigkeit auf aktuell aufgezeichneter Route</li>
                        <li><b><i>aktuell_max_luftfeuchtigkeit_innen</i></b>: Minimal gemessene
                            Innenraumluftfeuchtigkeit auf aktuell aufgezeichneter Route</li>
                    </ul>
                    <ul>
                        <li><b><i>gsm</i></b>: GSM Informationen als String (wie Provider, Signalstärke,
                            etc)</li>
                        <li><b><i>gsm_provider</i></b>: Name und ID des aktuellen Providers</li>
                        <li><b><i>gsm_connection_type</i></b>: GSM Verbindungstyp</li>
                        <li><b><i>gsm_netstate</i></b>: Aktueller GSM Netzstatus</li>
                        <li><b><i>gsm_external_ip</i></b>: Externe IP-Adresse (Providerseite)</li>
                        <li><b><i>gsm_last_update</i></b>: Zeitpuntk des letzten Updates der GSM Informationen</li>
                    </ul>
                    <hr>
                    <b>table</b> - Liefert eine HTML Tabelle anhand des Parameters <b>table</b> aus Daten aus der
                    Datenbank zurück. Mögliche Werte für den Parameter sind:<br>
                    <ul>
                        <li><b><i>reisen</i></b>: Tabelle mit allen Reisen die aufgezeichnet wurden.</li>
                        <li><b><i>reisen_info</i></b>: Tabelle mit Streckendetails zu allen Reisen die aufgezeichnet
                            wurden.</li>
                        <li><b><i>reisen_umgebungsinfo</i></b>: Tabelle mit Temperatur & Luftfeuchtigkeitsinformationen
                            zu allen Reisen die aufgezeichnet wurden.</li>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php
}

// Erstelle HTMLTabelle basierend auf SQL und vorgegebenenen Parametern
function createHTMLRow(string $data4WoMo_SQL, array $data4WoMo_field_list, string $data4WoMo_table_row) {

    // define standard return value
    $data4WoMo_loc_return = "";
        // Verarbeite die Parameter und generiere den Inhalt
        $data4WoMo_db_name = get_option('data4WoMo_db_name');
        $data4WoMo_db_host = get_option('data4WoMo_db_host');
        $data4WoMo_db_user = get_option('data4WoMo_db_user');
        $data4WoMo_db_passwd = get_option('data4WoMo_db_passwd');
    
        // Create MySQL connection
        $data4WoMo_funclink = mysqli_connect($data4WoMo_db_host, $data4WoMo_db_user, $data4WoMo_db_passwd, $data4WoMo_db_name);
    
        // Check connection
        if (mysqli_connect_errno()) {
            $data4WoMo_loc_return = "[!<b>e</b>=" . mysqli_connect_error() ."]";
        } else {
            // run MySQL script now
            if ($data4WoMo_result = mysqli_query($data4WoMo_funclink, $data4WoMo_SQL)) {
                while ($data4WoMo_row = mysqli_fetch_assoc($data4WoMo_result)) {
                    while ($loc_data4WoMo_sql_row = mysqli_fetch_assoc($data4WoMo_result)) {
                        $loc_data4WoMo_row = $data4WoMo_table_row;
                        foreach($data4WoMo_field_list as $data4WoMo_loc_table_field) {
                            if (isset($loc_data4WoMo_sql_row[$data4WoMo_loc_table_field])) {
                                $loc_data4WoMo_row = str_replace("[[". $data4WoMo_loc_table_field ."]]", $loc_data4WoMo_sql_row[$data4WoMo_loc_table_field], $loc_data4WoMo_row);
                            }                        
                        }                        
                        $data4WoMo_loc_return .= $loc_data4WoMo_row;                    
                    }
                }
            }
            mysqli_close($data4WoMo_funclink);
        }

        // now replace all fields without data with parameter N/A
        foreach($data4WoMo_field_list as $data4WoMo_loc_table_field) {
                $data4WoMo_loc_return = str_replace("[[". $data4WoMo_loc_table_field ."]]", "N/A", $data4WoMo_loc_return);
        }          

    return $data4WoMo_loc_return;
}

// Definiere den Shortcode
function data4WoMo_with_parametern($atts) {
    // Standard-Parameter
    $dataWoMo_return_HTML = "[empty]";
    $data4WoMo_default_atts = array(
        'value' => 'N/A',
        'table' => 'N/A'
    );

    // Extrahiere die übermittelten Parameter mit Standardwerten
    $data4WoMo_params = shortcode_atts($data4WoMo_default_atts, $atts);

    // Verarbeite die Parameter und generiere den Inhalt
    $data4WoMo_db_name = get_option('data4WoMo_db_name');
    $data4WoMo_db_host = get_option('data4WoMo_db_host');
    $data4WoMo_db_user = get_option('data4WoMo_db_user');
    $data4WoMo_db_passwd = get_option('data4WoMo_db_passwd');

    // Create MySQL connection
    $data4WoMo_dblink = mysqli_connect($data4WoMo_db_host, $data4WoMo_db_user, $data4WoMo_db_passwd, $data4WoMo_db_name);

    // Check connection
    if (mysqli_connect_errno()) {
        $dataWoMo_return_HTML = "[!<b>e</b>=" . mysqli_connect_error() ."]";
    } else {

        if ($data4WoMo_params['value'] != 'N/A') {

            // default values festlegen
            $data4WoMo_sql = "";
            $data4WoMo_sql_field = "Value";
            $data4WoMo_post_text = "";
            $data4WoMo_pre_text = "";

            switch(strtolower($data4WoMo_params['value'])){
                case "gsm":
                    $data4WoMo_sql = "SELECT CONCAT('<b>*',connstate,'*</b> (<i>',conntype,'</i>) mit IP-Adresse: <b>',sim_ip,'</b> auf Band *',Band,'* bei <b>',operator,'</b> mit Signalstärke (RSSI / RSRP / RSQR / SINR) <strong>',RSSI,' dBm / ',RSRP,' dB / ',RSRQ,' dB / ', SINR, ' dB</strong>') AS Value FROM gsm_data ORDER BY created_at DESC LIMIT 1;";
                    break;
                case "gsm_provider":
                    $data4WoMo_sql = "SELECT operator AS Value FROM gsm_data ORDER BY created_at DESC LIMIT 1;";
                    break;
                case "gsm_connection_type":
                    $data4WoMo_sql = "SELECT connstate AS Value FROM gsm_data ORDER BY created_at DESC LIMIT 1;";
                    break;
                case "gsm_netstate":
                    $data4WoMo_sql = "SELECT netstate AS Value FROM gsm_data ORDER BY created_at DESC LIMIT 1;";
                    break;
                case "gsm_external_ip":
                    $data4WoMo_sql = "SELECT sim_ip AS Value FROM gsm_data ORDER BY created_at DESC LIMIT 1;";
                    break;
                case "gsm_last_update":
                    $data4WoMo_sql = "SELECT created_at AS Value FROM gsm_data ORDER BY created_at DESC LIMIT 1;";
                    break;                
                case "total_strecke":
                    $data4WoMo_sql = "SELECT ROUND(SUM(distance / 1000),1) AS Value FROM gps_data;";
                    $data4WoMo_post_text = " km";
                    break;
                case "total_trackpoints":
                    $data4WoMo_sql = "SELECT COUNT(id) AS Value FROM gps_data;";
                    break;
                case "total_steigung_total":
                    $data4WoMo_sql = "SELECT ROUND(SUM(altitude_diff)/1000,2) AS Value FROM gps_data WHERE gps_data.altitude_diff > 0;";
                    $data4WoMo_post_text = " km";
                    break;
                case "total_gefaelle_total":
                    $data4WoMo_sql = "SELECT ROUND(SUM(altitude_diff)/1000,2) AS Value FROM gps_data WHERE gps_data.altitude_diff < 0;";
                    $data4WoMo_post_text = " km";
                    break;
                case "total_speed_max":
                    $data4WoMo_sql = "SELECT ROUND(speed_calc, 1) as Value FROM gps_data ORDER BY speed_calc DESC LIMIT 1;";
                    $data4WoMo_post_text = " km/h";
                    break;
                case "total_altitude_max":
                    $data4WoMo_sql = "SELECT ROUND(altitude_calc, 1) as Value FROM gps_data ORDER BY altitude_calc DESC LIMIT 1;";
                    $data4WoMo_post_text = " m.ü.M.";
                    break;
                case "total_altitude_min":
                    $data4WoMo_sql = "SELECT ROUND(altitude_calc, 1) as Value FROM gps_data WHERE altitude_calc IS NOT NULL AND altitude_calc != -100 ORDER BY altitude_calc ASC LIMIT 1;";
                    $data4WoMo_post_text = " m.ü.M.";
                    break;
                case "aktuell_strecke":
                    $data4WoMo_sql = "SELECT ROUND(SUM(distance / 1000),1) AS Value FROM gps_data WHERE gps_data.created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1);";
                    $data4WoMo_post_text = " km";
                    break;
                case "aktuell_trackpoints":
                    $data4WoMo_sql = "SELECT COUNT(id) AS Value FROM gps_data WHERE gps_data.created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1);";
                    break;
                case "aktuell_steigung_total":
                    $data4WoMo_sql = "SELECT ROUND(SUM(altitude_diff),2) AS Value FROM gps_data WHERE gps_data.altitude_diff > 0 AND gps_data.created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1);";
                    $data4WoMo_post_text = " m";
                    break;
                case "aktuell_gefaelle_total":
                    $data4WoMo_sql = "SELECT ROUND(SUM(altitude_diff),2) AS Value FROM gps_data WHERE gps_data.altitude_diff < 0 AND gps_data.created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1);";
                    $data4WoMo_post_text = " m";
                    break;
                case "aktuell_speed":
                    $data4WoMo_sql = "SELECT ROUND(speed_calc, 1) as Value FROM gps_data ORDER BY created_at DESC LIMIT 1;";
                    $data4WoMo_post_text = " km/h";
                    break; 
                case "aktuell_speed_max":
                    $data4WoMo_sql = "SELECT ROUND(speed_calc, 1) as Value FROM gps_data WHERE gps_data.created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY speed_calc DESC LIMIT 1;";
                    $data4WoMo_post_text = " km/h";
                    break;
                case "aktuell_altitude_max":
                    $data4WoMo_sql = "SELECT ROUND(altitude_calc, 1) as Value FROM gps_data WHERE gps_data.created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY altitude_calc DESC LIMIT 1;";
                    $data4WoMo_post_text = " m.ü.M.";
                    break;
                case "aktuell_altitude":
                    $data4WoMo_sql = "SELECT ROUND(altitude_calc, 1) as Value FROM gps_data ORDER BY created_at DESC LIMIT 1;";
                    $data4WoMo_post_text = " m.ü.M.";
                    break;
                case "aktuell_altitude_min":
                    $data4WoMo_sql = "SELECT ROUND(altitude_calc, 1) as Value FROM gps_data WHERE gps_data.created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) AND altitude_calc != -100 ORDER BY altitude_calc ASC LIMIT 1;";
                    $data4WoMo_post_text = " m.ü.M.";
                    break;
                case "aktuell_ort":
                    $data4WoMo_sql = "SELECT location as Value FROM gps_data ORDER BY created_at DESC LIMIT 1;";
                    break;
                case "aktuell_land":
                    $data4WoMo_sql = "SELECT country_name as Value FROM gps_data ORDER BY created_at DESC LIMIT 1;";
                    break;
                case "temperatur_innen":
                    $data4WoMo_sql = "SELECT ROUND(temperature, 1) AS Value FROM environment_data WHERE sensor_id=9 ORDER BY created_at DESC LIMIT 1;";
                    $data4WoMo_post_text = " °C";
                    break;
                case "min_temperatur_innen":
                    $data4WoMo_sql = "SELECT ROUND(temperature, 1) AS Value FROM environment_data WHERE sensor_id=9 ORDER BY temperature ASC LIMIT 1;";
                    $data4WoMo_post_text = " °C";
                    break;
                case "max_temperatur_innen":
                    $data4WoMo_sql = "SELECT ROUND(temperature, 1) AS Value FROM environment_data WHERE sensor_id=9 ORDER BY temperature DESC LIMIT 1;";
                    $data4WoMo_post_text = " °C";
                    break;
                case "aktuell_min_temperatur_innen":
                    $data4WoMo_sql = "SELECT ROUND(temperature, 1) AS Value FROM environment_data WHERE sensor_id=9 AND created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY temperature ASC LIMIT 1;";
                    $data4WoMo_post_text = " °C";
                    break;
                case "aktuell_max_temperatur_innen":
                    $data4WoMo_sql = "SELECT ROUND(temperature, 1) AS Value FROM environment_data WHERE sensor_id=9 AND created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY temperature DESC LIMIT 1;";
                    $data4WoMo_post_text = " °C";
                    break;                
                case "luftfeuchtigkeit_innen":
                    $data4WoMo_sql = "SELECT humidity FROM environment_data WHERE sensor_id=9 ORDER BY created_at DESC LIMIT 1;";
                    $data4WoMo_sql_field = "humidity";
                    $data4WoMo_post_text = " %";
                    break;      
                case "min_luftfeuchtigkeit_innen":
                    $data4WoMo_sql = "SELECT humidity FROM environment_data WHERE sensor_id=9 ORDER BY humidity ASC LIMIT 1;";
                    $data4WoMo_sql_field = "humidity";
                    $data4WoMo_post_text = " %";
                    break;
                case "max_luftfeuchtigkeit_innen":
                    $data4WoMo_sql = "SELECT humidity FROM environment_data WHERE sensor_id=9 ORDER BY humidity DESC LIMIT 1;";
                    $data4WoMo_sql_field = "humidity";
                    $data4WoMo_post_text = " %";
                    break;
                case "aktuell_min_luftfeuchtigkeit_innen":
                    $data4WoMo_sql = "SELECT humidity FROM environment_data WHERE sensor_id=9 AND created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY humidity ASC LIMIT 1;";
                    $data4WoMo_sql_field = "humidity";
                    $data4WoMo_post_text = " %";
                    break;
                case "aktuell_max_luftfeuchtigkeit_innen":
                    $data4WoMo_sql = "SELECT humidity FROM environment_data WHERE sensor_id=9 AND created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY humidity DESC LIMIT 1;";
                    $data4WoMo_sql_field = "humidity";
                    $data4WoMo_post_text = " %";
                    break;
                case "temperatur_aussen":
                    $data4WoMo_sql = "SELECT ROUND(temperature, 1) as Value FROM environment_data WHERE sensor_id=16 ORDER BY created_at DESC LIMIT 1;";
                    $data4WoMo_post_text = " °C";
                    break;
                case "min_temperatur_aussen":
                    $data4WoMo_sql = "SELECT ROUND(temperature, 1) as Value FROM environment_data WHERE sensor_id=16 ORDER BY temperature ASC LIMIT 1;";
                    $data4WoMo_post_text = " °C";
                    break;
                case "max_temperatur_aussen":
                    $data4WoMo_sql = "SELECT ROUND(temperature, 1) as Value FROM environment_data WHERE sensor_id=16 ORDER BY temperature DESC LIMIT 1;";
                    $data4WoMo_post_text = " °C";
                    break;
                case "aktuell_min_temperatur_aussen":
                    $data4WoMo_sql = "SELECT ROUND(temperature, 1) as Value FROM environment_data WHERE sensor_id=16 AND created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY temperature ASC LIMIT 1;";
                    $data4WoMo_post_text = " °C";
                    break;
                case "aktuell_max_temperatur_aussen":
                    $data4WoMo_sql = "SELECT ROUND(temperature, 1) as Value FROM environment_data WHERE sensor_id=16 AND created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY temperature DESC LIMIT 1;";
                    $data4WoMo_post_text = " °C";
                    break;
                case "luftfeuchtigkeit_aussen":
                    $data4WoMo_sql = "SELECT humidity FROM environment_data WHERE sensor_id=16 ORDER BY created_at DESC LIMIT 1;";
                    $data4WoMo_sql_field = "humidity";
                    $data4WoMo_post_text = " %";
                    break;
                case "min_luftfeuchtigkeit_aussen":
                    $data4WoMo_sql = "SELECT humidity FROM environment_data WHERE sensor_id=16 ORDER BY humidity ASC LIMIT 1;";
                    $data4WoMo_sql_field = "humidity";
                    $data4WoMo_post_text = " %";
                    break;
                case "max_luftfeuchtigkeit_aussen":
                    $data4WoMo_sql = "SELECT humidity FROM environment_data WHERE sensor_id=16 ORDER BY humidity DESC LIMIT 1;";
                    $data4WoMo_sql_field = "humidity";
                    $data4WoMo_post_text = " %";
                    break;
                case "aktuell_min_luftfeuchtigkeit_aussen":
                    $data4WoMo_sql = "SELECT humidity FROM environment_data WHERE sensor_id=16 AND created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY humidity ASC LIMIT 1;";
                    $data4WoMo_sql_field = "humidity";
                    $data4WoMo_post_text = " %";
                    break;
                case "aktuell_max_luftfeuchtigkeit_aussen":
                    $data4WoMo_sql = "SELECT humidity FROM environment_data WHERE sensor_id=16 AND created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY humidity DESC LIMIT 1;";
                    $data4WoMo_sql_field = "humidity";
                    $data4WoMo_post_text = " %";
                    break;
                default:
                    $data4WoMo_output = "Ungültiger Parameterwert: >". strtolower($data4WoMo_params['bezeichnung']) ."<";
                    break;
            }

            // run MySQL script now
            if ($data4WoMo_result = mysqli_query($data4WoMo_dblink, $data4WoMo_sql)) {
                while ($data4WoMo_row = mysqli_fetch_assoc($data4WoMo_result)) {
                    $data4WoMo_output = $data4WoMo_row[$data4WoMo_sql_field];
                }
            }
            
            // prüfe ob der Rückgabewert leer ist und wenn ja ersetze durch 'Fehler'
            if (empty($data4WoMo_output) || strlen($data4WoMo_output) === 0) {
                $data4WoMo_output = "N/A";
            } 

            $dataWoMo_return_HTML = $data4WoMo_pre_text . "" .  $data4WoMo_output . "" . $data4WoMo_post_text;
            
        } else {
            if ($data4WoMo_params['table'] != 'N/A') {

                // default values festlegen
                $data4WoMo_sql = "";
                $data4WoMo_sql_field_list = [""];
                $data4WoMo_HTML_td_row = "";
    
                switch(strtolower($data4WoMo_params['table'])) {
                    case "reisen":
                        $data4WoMo_sql = "SELECT id, name, DATE_FORMAT(journey_begins,'%d.%m.%y %H:%i') as JStart, DATE_FORMAT(journey_ends,'%d.%m.%y %H:%i') as JEnd FROM journeys where id != 8 order by journey_begins ASC;";                      
                        $data4WoMo_sql_field_list = ["name", "JStart", "JEnd", "id"];
                        $dataWoMo_return_HTML = "<table border=0><tr><td><h5>Name</h5></td><td><center><h5>Start</h5></center></td><td><center><h5>Ende</h5></center></td><td><center><h5>Route</h5></center></td></tr>";
                        $dataWoMo_row_HTML = "<tr><td>[[name]]</td><td><center>[[JStart]]</center></td><td><center>[[JEnd]]</center></td><td><center><a target=_new href=\"https://service.zuegers-on-the-road.observer/get/show_trip.php?trip_id=[[id]]\">Öffne Maps</a></center></td></tr>";
                        break;
                    case "reisen_info":
                        $data4WoMo_sql = "SELECT name, CONCAT(DATEDIFF(journey_ends, journey_begins), ' Tage') as days, CONCAT((select Round(SUM(distance)/1000,0) from gps_data where created_at > journey_begins and created_at < journey_ends order by created_at ASC),' km') as distance, CONCAT((select ROUND(altitude_calc,0) from gps_data where created_at > journey_begins and created_at < journey_ends order by altitude_calc DESC Limit 1),' m.ü.M') as maxhigh, CONCAT((select ROUND(speed_calc,1) from gps_data where created_at > journey_begins and created_at < journey_ends order by speed_calc DESC Limit 1),' km/h') as maxspeed FROM journeys where id != 8 order by journey_begins ASC;";
                        $data4WoMo_sql_field_list = ["name", "days", "distance", "maxhigh", "maxspeed"];
                        $dataWoMo_return_HTML = "<table border=0><tr><td><h5>Name</h5></td><td><center><h5>Reisezeit</h5></center></td><td><center><h5>Distanz</h5></center></td><td><center><h5>Höhe (max)</h5></center></td><td><center><h5>Gesch. (max)</h5></center></td></tr>";
                        $dataWoMo_row_HTML = "<tr><td>[[name]]</td><td><center>[[days]]</center></td><td><center>[[distance]]</center></td><td><center>[[maxhigh]]</center></td><td><center>[[maxspeed]]</center></td></tr>";
                        break;
                    case "reisen_env_innen":
                        $data4WoMo_sql = "SELECT name, CONCAT((select temperature from environment_data where sensor_id=9 and created_at > journey_begins and created_at < journey_ends order by temperature ASC LIMIT 1),' °C') as inside_tempmin, CONCAT((select temperature from environment_data where sensor_id=9 and created_at > journey_begins and created_at < journey_ends order by temperature DESC LIMIT 1),' °C') as inside_tempmax, CONCAT((select ROUND(AVG(temperature),1) from environment_data where sensor_id=9 and created_at > journey_begins and created_at < journey_ends),' °C') as inside_tempavg, CONCAT((select humidity from environment_data where sensor_id=9 and created_at > journey_begins and created_at < journey_ends order by humidity ASC LIMIT 1),' %') as inside_hummin, CONCAT((select humidity from environment_data where sensor_id=9 and created_at > journey_begins and created_at < journey_ends order by humidity DESC LIMIT 1),' %') as inside_hummax, CONCAT((select ROUND(AVG(humidity),0) from environment_data where sensor_id=9 and created_at > journey_begins and created_at < journey_ends),' %') as inside_humavg FROM journeys where id != 8 order by journey_begins ASC;";
                        $data4WoMo_sql_field_list = ["name", "inside_tempmin", "inside_tempavg", "inside_tempmax", "inside_hummin", "inside_humavg", "inside_hummax"];
                        $dataWoMo_return_HTML = "<table border=0><tr><td width='40%'></td><td colspan='3' width='30%'><center><h5>Temperatur<br>Wohnraum</h5></center></td><td colspan='3' width='30%'><center><h5>Luftfeuchtigkeit<br>Wohnraum</h5></center></td></tr><tr><td width='40%'><h5>Name</h5></td><td with='10%'><center><b>Min</b></center></td><td with='10%'><center><b>Durch.</b></center></td><td with='10%'><center><b>Max</b></center></td><td with='10%'><center><b>Min</b></center></td><td with='10%'><center><b>Durch.</b></center></td><td with='10%'><center><b>Max</b></center></td><tr>";
                        $dataWoMo_row_HTML = "<tr><td>[[name]]</td><td><center>[[inside_tempmin]]</center></td><td><center>[[inside_tempavg]]</center></td><td><center>[[inside_tempmax]]</center></td><td><center>[[inside_hummin]]</center></td><td><center>[[inside_humavg]]</center></td><td><center>[[inside_hummax]]</center></td></tr>";
                        break;
                    case "reisen_env_aussen":
                        $data4WoMo_sql = "SELECT name, CONCAT((select temperature from environment_data where sensor_id=16 and created_at > journey_begins and created_at < journey_ends order by temperature ASC LIMIT 1),' °C') as inside_tempmin, CONCAT((select temperature from environment_data where sensor_id=16 and created_at > journey_begins and created_at < journey_ends order by temperature DESC LIMIT 1),' °C') as inside_tempmax, CONCAT((select ROUND(AVG(temperature),1) from environment_data where sensor_id=16 and created_at > journey_begins and created_at < journey_ends),' °C') as inside_tempavg, CONCAT((select humidity from environment_data where sensor_id=16 and created_at > journey_begins and created_at < journey_ends order by humidity ASC LIMIT 1),' %') as inside_hummin, CONCAT((select humidity from environment_data where sensor_id=16 and created_at > journey_begins and created_at < journey_ends order by humidity DESC LIMIT 1),' %') as inside_hummax, CONCAT((select ROUND(AVG(humidity),0) from environment_data where sensor_id=16 and created_at > journey_begins and created_at < journey_ends),' %') as inside_humavg FROM journeys where id != 8 order by journey_begins ASC;";
                        $data4WoMo_sql_field_list = ["name", "inside_tempmin", "inside_tempavg", "inside_tempmax", "inside_hummin", "inside_humavg", "inside_hummax"];
                        $dataWoMo_return_HTML = "<table border=0><tr><td width='40%'></td><td colspan='3' width='30%'><center><h5>Temperatur<br>Wohnraum</h5></center></td><td colspan='3' width='30%'><center><h5>Luftfeuchtigkeit<br>Wohnraum</h5></center></td></tr><tr><td width='40%'><h5>Name</h5></td><td with='10%'><center><b>Min</b></center></td><td with='10%'><center><b>Durch.</b></center></td><td with='10%'><center><b>Max</b></center></td><td with='10%'><center><b>Min</b></center></td><td with='10%'><center><b>Durch.</b></center></td><td with='10%'><center><b>Max</b></center></td><tr>";
                        $dataWoMo_row_HTML = "<tr><td>[[name]]</td><td><center>[[inside_tempmin]]</center></td><td><center>[[inside_tempavg]]</center></td><td><center>[[inside_tempmax]]</center></td><td><center>[[inside_hummin]]</center></td><td><center>[[inside_humavg]]</center></td><td><center>[[inside_hummax]]</center></td></tr>";
                        break;
                    default:
                        $dataWoMo_return_HTML = "Ungültiger Parameterwert: >". strtolower($data4WoMo_params['bezeichnung']) ."<";
                        break;
                }
                $dataWoMo_return_HTML .= createHTMLRow($data4WoMo_sql, $data4WoMo_sql_field_list, $dataWoMo_row_HTML). "</table>";
        } else {
            $dataWoMo_return_HTML = "<b>ERROR</b> no valid attribute provided";
        }
    }
    return $dataWoMo_return_HTML;
    }
}

add_shortcode('data4WoMo', 'data4WoMo_with_parametern');

// Entferne die Optionen bei der Deaktivierung des Plugins
register_deactivation_hook(__FILE__, 'data4WoMo_remove_options');

function data4WoMo_remove_options() {
    // Entferne die Option für den Datenbanknamen
    unregister_setting('data4WoMo_options', 'data4WoMo_db_name');
    unregister_setting('data4WoMo_options', 'data4WoMo_db_host');    
    unregister_setting('data4WoMo_options', 'data4WoMo_db_passwd');
    unregister_setting('data4WoMo_options', 'data4WoMo_db_user');
}