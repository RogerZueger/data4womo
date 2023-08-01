<?php
/*
Plugin Name: data4WoMo - Daten für mein Wohnmobil
Plugin URI: https://www.roger-zueger.ch
Description: Ein WordPress-Plugin, das bestimmte Werte und Parameter aus einer zentralen MySQL Datenbank ausliest, welche zuvor dort von verschiedenen Tools & Programmen gespeichert wurden.
Version: 0.2
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
        <p>[data4WoMo_Value bezeichnung="<i>Funktion</i>"]</p>
        <table border="1" spacing="5">
            <tr>
                <th valign="top" width="200px">Shortcode</th>
                <th valign="top">Funktion und Parameter</th>
            </tr>
            <tr>
                <td valign="top">data4WoMo_Value</td>
                <td valign="top">Liefert einen (berechneten) Wert anhand des Parameters <b>Bezeichnung</b> aus der
                    Datenbank
                    zurück.
                    Mögliche Werte für den Parameter sind:<br>
                    <p><b><i>aktuell_altitude_max</i></b>: Höchst gemessener Punkt gemäss GPS auf der aktuellen
                        Route<br>
                        <b><i>aktuell_altitude_min</i></b>: Tiefster gemessener Punkt gemäss GPS auf der aktuellen
                        Route<br>
                        <b><i>aktuell_strecke</i></b>: Total zurückgelegte Strecke in km gemäss internem GPS der
                        aktuellen Route<br>
                        <b><i>aktuell_trackpoints</i></b>: Anzahl aufgezeichneter Trackpoints (GPS Punkte) der aktuellen
                        Route<br>
                        <b><i>aktuell_speed_max</i></b>: Höchst gemessene Geschwindigkeit gemäss GPS auf der aktuellen
                        Route<br>
                        <b><i>aktuell_gefaelle_total</i></b>: Total aller Gefälle (in Meter) gemäss GPS/Höhendaten
                        Google auf der aktuellen
                        Route<br>
                        <b><i>aktuell_steigung_total</i></b>: Total aller Steigungen (in Meter) gemäss GPS/Höhendaten
                        Google auf der aktuellen
                        Route<br>
                        <b><i>aktuell_ort</i></b>: Aktueller Ort (Standort) gemäss GPS und Google Geolocation Dienst<br>
                        <b><i>aktuell_land</i></b>: Aktuelles Land (Standort) gemäss GPS und Google Geolocation
                        Dienst<br>
                    </p>
                    <p><b><i>total_altitude_max</i></b>: Höchst gemessener Punkt gemäss GPS aller aufgezeichneten
                        Routen<br>
                        <b><i>total_altitude_min</i></b>: Tiefster gemessener Punkt gemäss GPS aller aufgezeichneten
                        Routen<br>
                        <b><i>total_strecke</i></b>: Total zurückgelegte Strecke in km gemäss internem GPS aller
                        aufgezeichneten Routen<br>
                        <b><i>total_trackpoints</i></b>: Anzahl aufgezeichneter Trackpoints (GPS Punkte) aller
                        aufgezeichneten Routen<br>
                        <b><i>total_speed_max</i></b>: Höchst gemessene Geschwindigkeit gemäss GPS auf der allen
                        aufgezeichneten Routen<br>
                        <b><i>total_gefaelle_total</i></b>: Total aller Gefälle (in Meter) gemäss GPS/Höhendaten
                        Google auf allen aufgezeichneten Routen<br>
                        <b><i>total_steigung_total</i></b>: Total aller Steigungen (in Meter) gemäss GPS/Höhendaten
                        Google auf allen aufgezeichneten
                        Routen<br>
                    </p>
                    <p><b><i>temperatur_aussen</i></b>: Zuletzt gemessene Aussentemperatur (wird ca. alle
                        5-10min aktualisiert)<br>
                        <b><i>min_temperatur_aussen</i></b>: Minimal gemessene Aussentemperatur auf allen
                        aufgezeichneten Routen<br>
                        <b><i>max_temperatur_aussen</i></b>: Maximal gemessene Aussentemperatur auf allen
                        aufgezeichneten Routen<br>
                        <b><i>aktuell_min_temperatur_aussen</i></b>: Minimal gemessene Aussentemperatur auf aktuell
                        aufgezeichneter Route<br>
                        <b><i>aktuell_max_temperatur_aussen</i></b>: Maximal gemessene Aussentemperatur auf aktuell
                        aufgezeichneter Route<br>
                        <b><i>luftfeuchtigkeit_aussen</i></b>: Zuletzt gemessene Luftfeuchtigkeit aussen (wird ca. alle
                        5-10min aktualisiert)<br>
                        <b><i>min_luftfeuchtigkeit_aussen</i></b>: Minimal gemessene Aussenluftfeuchtigkeit auf allen
                        aufgezeichneten Routen<br>
                        <b><i>max_luftfeuchtigkeit_aussen</i></b>: Maximal gemessene Aussenluftfeuchtigkeit auf allen
                        aufgezeichneten Routen<br>
                        <b><i>aktuell_min_luftfeuchtigkeit_aussen</i></b>: Minimal gemessene Aussenluftfeuchtigkeit auf
                        aktuell aufgezeichneter Route<br>
                        <b><i>aktuell_max_luftfeuchtigkeit_aussen</i></b>: Maximal gemessene Aussenluftfeuchtigkeit auf
                        aktuell aufgezeichneter Route<br>
                        <b><i>temperatur_innen</i></b>: Zuletzt gemessene Innenraumtemperatur (wird ca. alle
                        5-10min aktualisiert)<br>
                        <b><i>min_temperatur_innen</i></b>: Minimal gemessene Innenraumtemperatur auf allen
                        aufgezeichneten Routen<br>
                        <b><i>max_temperatur_innen</i></b>: Maximal gemessene Innenraumtemperatur auf allen
                        aufgezeichneten Routen<br>
                        <b><i>aktuell_min_temperatur_innen</i></b>: Minimal gemessene Innenraumtemperatur auf aktuell
                        aufgezeichneter Route<br>
                        <b><i>aktuell_max_temperatur_innen</i></b>: Maximal gemessene Innenraumtemperatur auf aktuell
                        aufgezeichneter Route<br>
                        <b><i>luftfeuchtigkeit_innen</i></b>: Zuletzt gemessene Luftfeuchtigkeit im Innenraum (wird ca.
                        alle 5-10min aktualisiert)<br>
                        <b><i>min_luftfeuchtigkeit_innen</i></b>: Minimal gemessene Innenraumluftfeuchtigkeit auf allen
                        aufgezeichneten Routen<br>
                        <b><i>max_luftfeuchtigkeit_innen</i></b>: Minimal gemessene Innenraumluftfeuchtigkeit auf allen
                        aufgezeichneten Routen<br>
                        <b><i>aktuell_min_luftfeuchtigkeit_innen</i></b>: Minimal gemessene Innenraumluftfeuchtigkeit
                        auf aktuell aufgezeichneter Route<br>
                        <b><i>aktuell_max_luftfeuchtigkeit_innen</i></b>: Minimal gemessene Innenraumluftfeuchtigkeit
                        auf aktuell aufgezeichneter Route<br>
                    </p>
                    <p><b><i>gsm</i></b>: GSM Informationen als String (wie Provider, Signalstärke, etc)<br>
                        <b><i>gsm_provider</i></b>: Name und ID des aktuellen Providers<br>
                        <b><i>gsm_connection_type</i></b>: GSM Verbindungstyp<br>
                        <b><i>gsm_netstate</i></b>: Aktueller GSM Netzstatus<br>
                        <b><i>gsm_external_ip</i></b>: Externe IP-Adresse (Providerseite)<br>
                        <b><i>gsm_last_update</i></b>: Zeitpuntk des letzten Updates der GSM Informationen<br>
                    </p>
                </td>
        </table>
    </div>
</div>
<?php
}

// Definiere den Shortcode
function data4WoMo_with_parametern($atts) {
    // Standard-Parameter
    $data4WoMo_output = "N/A";
    $data4WoMo_default_atts = array(
        'bezeichnung' => 'temperatur_aussen'
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
        $data4WoMo_output = "Verbindung zur MySQL Datanbank fehlgeschlagen! Fehlermeldung: " . mysqli_connect_error();
    } else {

        // default values festlegen
        $data4WoMo_sql = "";
        $data4WoMo_sql_field = "Value";
        $data4WoMo_post_text = "";
        $data4WoMo_pre_text = "";

        switch(strtolower($data4WoMo_params['bezeichnung'])){
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
                $data4WoMo_sql = "SELECT ROUND(altitude_calc, 1) as Value FROM gps_data WHERE altitude_calc IS NOT NULL ORDER BY altitude_calc ASC LIMIT 1;";
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
                $data4WoMo_sql = "SELECT ROUND(altitude_calc, 1) as Value FROM gps_data WHERE gps_data.created_at > (SELECT journey_begins FROM journeys WHERE journey_ends ='0000-00-00 00:00:00' order by id DESC LIMIT 1) ORDER BY altitude_calc ASC LIMIT 1;";
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
    }
   
    return $data4WoMo_pre_text . "" .  $data4WoMo_output . "" . $data4WoMo_post_text;
}
add_shortcode('data4WoMo_Value', 'data4WoMo_with_parametern');

// Entferne die Optionen bei der Deaktivierung des Plugins
register_deactivation_hook(__FILE__, 'data4WoMo_remove_options');

function data4WoMo_remove_options() {
    // Entferne die Option für den Datenbanknamen
    unregister_setting('data4WoMo_options', 'data4WoMo_db_name');
    unregister_setting('data4WoMo_options', 'data4WoMo_db_host');    
    unregister_setting('data4WoMo_options', 'data4WoMo_db_passwd');
    unregister_setting('data4WoMo_options', 'data4WoMo_db_user');
}