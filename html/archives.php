<?php

// HとWを取得
// $a = explode(" ", $array[0]);
// $h = $a[0];
// $w = $a[1];

// // 1行目の2つの数字を取得
// $b = explode(" ", $array[1]);
// $h1_1 = $b[0];
// $h1_2 = $b[1];
// $h1_difference = $h1_2 - $h1_1;
// // 最終結果の配列に1行目の結果を配列で代入
// $results[] = make_row($h1_1, $h1_difference, $w);

// // 2行目の2つの数字を取得
// $c = explode(" ", $array[2]);
// $h2_1 = $c[0];
// $h2_2 = $c[1];
// $h2_difference = $h2_2 - $h2_1;
// $results[] = make_row($h2_1, $h2_difference, $w);

// // １行目の2行目の最初の数の差
// $h_difference = $h2_1 - $h1_1;
// // １行目の増加数と2行目の増加数の差
// $difference_change = $h2_difference - $h1_difference;
// $new_h = $h2_1;

// for ($i=3; $i <= $h ; $i++) { 
//     // １行目の増加数と2行目の増加数が異なる場合、増加量も変化していく
//     if($difference_change !== 0){
//         $h2_difference += $difference_change; 
//     }
//     // 行の最初の数
//     $new_h += $h_difference;
//     // 行の最初の数と増加量、列数によってその行の結果を配列で代入
//     $results[] = make_row($new_h, $h2_difference, $w);
// }

// // 出力
// foreach ($results as $row) { 
//     echo implode(" ", $row) . "\n";
// }

// // 行の最初の数と増加量、列数によってその行の結果を配列で代入
// function make_row($h1, $difference, $w){
//     // 行の最初の数はそのまま代入
//     $row[] = $h1;
//     $new_w = $h1;
//     // 2つ目以降
//     for ($i=2; $i <= $w; $i++) {
//         $new_w += $difference; 
//         $row[] = $new_w;
//     }
//     return $row;
// }



// $b = explode(" ", $array[1]);
// $current_h = $b[0];
// $current_w = $b[1];

// $current_h = $b[0];
// $current_w = $b[1];

// // $current_h = 2;
// // $current_w = 1;
// // var_dump($h, $w, $current_h, $current_w);

// $direction = 0;

// for ($i=0; $i <= 2000 ; $i++) { 
//     // 街の外にでたら終わり
//     if($current_h < 1 || $current_h > $h || $current_w < 1 || $current_w > $w){
//     break;
//     }

//     // ターゲットの家を取得
//     $h_number = $current_h + 1; 
//     $w_number = $current_w - 1;
//     $target_h = $array[$h_number];
//     $target = substr($target_h, $w_number, 1);
    
//     // 家が富豪の時
//     if($target === "*"){
//         $array[$h_number] = substr_replace($target_h, ".", $w_number, 1);
//         $direction = change_left($direction);
//         $current_h = next_current_h($current_h, $direction);
//         $current_w = next_current_w($current_w, $direction);
//     } else {
//     // 家が庶民の時
//         $array[$h_number] = substr_replace($target_h, "*", $w_number, 1);
//         $direction = change_right($direction);
//         $current_h = next_current_h($current_h, $direction);
//         $current_w = next_current_w($current_w, $direction);
//     }

//     // var_dump($current_h, $current_w, $direction);
// }

// // 出力
// for ($i=2; $i <= $w ; $i++) { 
//     echo $array[$i] . "\n";
// }

// function next_current_h($h, $direction){
//     // 北を向いているとき、Hを1つ減らして上に
//     if($direction === 0){
//         $h--;
//     }
    
//     // 南を向いているとき、Hを1つ増やして上に
//     if($direction === 2){
//         $h++;
//     }
//     return $h;
// }




// // 自分の得意な言語で
//     // Let's チャレンジ！！

// while ($line = fgets(STDIN)) {
//     // 配列を生成する
//     $s[] = trim($line);
//     }
    
//     $a = explode(" ", $s[0]);
//     $candi = $a[0];
//     $people = $a[1];
//     $talks = $a[2];

//     for($i = 1; $i <= $candi; $i++){
//         $supporters[$i] = 0; 
//     }
//     // var_dump($supporters);
//     for($i = 1; $i <= $talks; $i++){
//         $speaker = $s[$i];
//         // var_dump($supporters[$speaker]);
//         // 無支持者が1人以上いるとき
//         if($people > 0){
//             $supporters[$speaker] ++;
//             $people --;
//         }
        
//         for($j = 1; $j <= $candi; $j++){
//             if($supporters[$j] > 0) {
//                 $supporters[$j] --;
//                 $supporters[$speaker] ++;
//             }
//         }
//     }
    

//     $max_supporters = max($supporters);
    
//     for($j = 1; $j <= $candi; $j++){
//         if($supporters[$j] == $max_supporters) {
//             echo $j . "\n";
//         }
//     }