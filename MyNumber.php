<?php

date_default_timezone_set('Asia/Seoul'); //---timezone 설정

$MyNumber = $_GET['MyNumber'];
$CNarray = preg_split("[-]", $MyNumber);




if (strlen($MyNumber) != 14) {
    echo "재입력하십시오";
}

/*//---For Test
echo "내 주민 번호야 $MyNumber";
echo "<br>";

echo "앞자리야$CNarray[0]";
echo "<br>";
echo "뒷자리야$CNarray[1]";*/

$Gender = str_split($CNarray[1], 1); //--- str_split : 글자 수 만큼 Split

//---Check Gender
switch ($Gender[0]) {
    case 1:
    case 3:
        echo "$MyNumber : 남성";
        echo "<br>";
        break;

    case 2:
    case 4:
        echo "$MyNumber : 여성";
        echo "<br>";
        break;
}

//--- Number valid Check

$MyNumberSum = 0;

$FrontNumber = str_split($CNarray[0], 1);
$BackNumber = str_split($CNarray[1], 1);

//---frontNumber = 6자리, [0] - [5] Index
//--- backNumber = 7자리, [0] - [5] Index까지는 연산, [6] 은 비교

for ($i = 0, $j = 2; $i < strlen($CNarray[0]); $i++, $j++) {
    $MyNumberSum += $FrontNumber[$i] * $j;
}


for ($i = 0, $j = 8; $i < (strlen($CNarray[1]) - 1); $i++, $j++) {

    if ($i > 1) {
        $j = $i;

        $MyNumberSum += $BackNumber[$i] * $j;
    }

    else {
        $MyNumberSum += $BackNumber[$i] * $j;
    }
}

$CheckNum = 11 - ($MyNumberSum % 11);

if ($CheckNum % 10 == $BackNumber[6]) {
    echo "유효한 주민번호 입니다";
    echo "<br>";
} else {
    echo "유효한 주민번호가 아닙니다";
    echo "<br>";
}


//---Print Birth YEAR,MONTH,DATE

$Birth = str_split($CNarray[0], 2);

//---YEAR
if ($Birth[0] > 18) {
    $BirthYEAR = 1900 + $Birth[0];
} else {
    $BirthYEAR = 2000 + $Birth[0];
}
//---MONTH
$BirthMONTH = $Birth[1];

//---DATE
$BirthDATE = $Birth[2];


echo "생년 월일 : $BirthYEAR 년 $BirthMONTH 월 $BirthDATE 일";
echo "<br>";


//--- Check D-DAY from BirthDay (Use abs)

$now = strtotime(date("Y-m-d"));

$SetYEAR = 0; //--- 생일이 지났으면 그 해 +1 , 지나지않았으면 그 해 YEAR값


if ($BirthMONTH > (date("m"))) {
    $SetYEAR = date("Y");
}

else {
    $SetYEAR = date("Y") + 1;
}


$D_DAY = strtotime("$SetYEAR-$BirthMONTH-$BirthDATE");
$Result = $now - $D_DAY;
$Result = $Result / 60 / 60 / 24; //---초,시간,일,개월
echo "생일까지 D-DAY :";
echo abs($Result);
echo "일 남았습니다";

echo "<br>";


//--- Number Of Month After Birth

$now = strtotime(date("Y-m-d"));
$D_DAY = strtotime("$BirthYEAR-$BirthMONTH-$BirthDATE");
$Result = $now - $D_DAY;
$Result = $Result / 60 / 60 / 24 / 30; //---초,시간,일,개월 //---윤달 계산은 제외 했습니다.
echo "생 후 :  ";
echo (int)($Result);
echo "개월 지났습니다"; //---소수점 표기 하지 않음


?>