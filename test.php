<?php
$timezones = array(
    'Asia/Kolkata'      => "(GMT+05:30) Kolkata/India",
    'Asia/Colombo'      => "(GMT+05:30) Colombo/Sri Lanka",
    'Asia/Kathmandu'    => "(GMT+05:45) Kathmandu/Nepal",
    'Asia/Yangon'       => "(GMT+06:30) Yangon/Myanmar",
    'Asia/Makassar'     => "(GMT+08:00) Makassar/Bali",
    'Asia/Manila'       => "(GMT+08:00) Manila/Philippines",
    'Asia/Tokyo'        => "(GMT+09:00) Tokyo/Japan"
    );
?>

<form method="post">
    <input required type="time" name="date" value="<?php echo !empty($_POST['date']) ? $_POST['date'] : '' ?>"/>
    <select required name="zone">
        <?php

foreach($timezones as $key => $value){
    if(isset($_POST['zone']) && $_POST['zone']==$key) {
        echo "<option selected name=\"zone\" value=\"$key\">$value</option>";
    } else {
        echo "<option name=\"zone\" value=\"$key\">$value</option>";
    }
        
}
?>
    </select>
    <input type="submit" value="Convert" />
</form>
<?php
if(isset($_POST['date']) && isset($_POST['zone'])) {
    try {
        $data = [];
        foreach($timezones as $key => $value){
            $data[$key]['test'] = new DateTime($_POST['date'], new DateTimeZone($_POST['zone']));
            $data[$key]['test']->setTimezone(new DateTimeZone($key));

            $data[$key]['result'] = $data[$key]['test']->format('h:i A');
            $data[$key]['title'] = $value;
        }
        
        // $result = $hongkong->format('h:i A');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if(isset($_POST['date']) || isset($_POST['zone'])) {
echo "<br>";
foreach($data as $value){
echo $value['result']. " > " .$value['title'];
echo "<br>";
}

}
?>