<?php 

function CookieEncode($str){
    $encoded = base64_encode($str); // Metni base64 ile kodla
    $encoded = str_replace(['+', '/', '='], ['_', '-', ''], $encoded); // Bazı özel karakterleri değiştir
    return $encoded;
}

function CookieDecode($str){
    $str = str_replace(['_', '-'], ['+', '/'], $str); // Değiştirilen özel karakterleri geri al
    $decoded = base64_decode($str); // Base64 ile kodlanmış metni çöz
    return $decoded;
}

function Number($number){

    return number_format($number, 0, ",", ".");

}

function Balance($number){

    return number_format($number, 2, ",", ".");

}

function TimePlus($second){

    $time = time() + $second;
    return date('Y-m-d H:i:s', $time);

}

function TimeMinus($second){
    
    $time = time() - $second;
    return date('Y-m-d H:i:s', $time);

}

function DatePlus($second){

    $date = time() + $second;
    return date('Y-m-d', $date);

}

function DateMinus($second){

    $date = time() - $second;
    return date('Y-m-d', $date);
    
}

function DateDifference($date1, $date2){
    
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);

    $interval = $datetime1->diff($datetime2);

    return $interval->format('%a');

}

function TextReText($text, $chunkSize, $symbol) {

    $chunks = str_split($text, $chunkSize);  // Metni belirtilen boyutta parçalara böl
    $result = implode($symbol, $chunks);  // Parçaları birleştir ve bir boşlukla ayır

    return $result;
    
}

function DateReplace($date){

    return $date;

}

function MaskedText($text, $gosterilecek_karakter_sayisi) {

    // Gösterilecek karakter sayısı metnin uzunluğundan büyükse, metnin tamamını göster
    if ($gosterilecek_karakter_sayisi >= strlen($text)) {
        return $text;
    }

    $goster = mb_substr($text, 0, $gosterilecek_karakter_sayisi); // Gösterilecek karakterleri al
    $gizle = str_repeat('*', strlen($text) - $gosterilecek_karakter_sayisi); // Geri kalan kısmı yıldız (*) ile değiştir
    
    return $goster . $gizle;

}

?>