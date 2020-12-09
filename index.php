<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Weather today</title>
</head>
<body>
    <?php include "config.php";?>
    <?php include "functions.php";?>
    <main>
        <div class="weather-block-wrapper">
        <?php
            // Get cities list from musement.com
            $cities_url = 'https://api.musement.com/api/v3/cities';
            $cities = array_slice(json_decode(get_data_response($cities_url), true), 0, $CITIES_COUNT);

            foreach ($cities as $city_num => $city) {
                $city_name = $city['name'];

                // Setup query parametres
                $options = array(
                    'key' => $API_KEY,
                    'q' => $city_name,
                    'days' => 2,
                );

                // Get weather data array from weatherapi
                $weather_url = 'http://api.weatherapi.com/v1/forecast.json'. '?' . http_build_query($options);
                $data = json_decode(get_data_response($weather_url), true);

                if (!array_key_exists('error', $data)) {
                    $w_today = $data['forecast']['forecastday'][0]['day']['condition']['text'];
                    $w_tomorrow = $data['forecast']['forecastday'][1]['day']['condition']['text'];
                    $oputput_str = 'Processed city ' . $city_name. ' | ' . $w_today . ' - ' . $w_tomorrow;
                    echo('<p class="weather-block">' . $oputput_str . '</p>');
                }
            }
        ?>
        </div>
    </main>
</body>
</html>