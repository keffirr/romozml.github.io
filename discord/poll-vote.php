<?php
// Åñëè  çàïðîñ íå AJAX (XMLHttpRequest), òî çàâåðøèòü ðàáîòó
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {return;}

if (empty($_POST['id'])) {exit();}

$nameFile = 'poll-results.txt';

$id = $_POST['id'];
$answer = $_POST['poll'];
$count = $_POST['count'];

if (isset($_COOKIE['polls'])) {
  $arrayPolls = explode(',',$_COOKIE['polls']);
  if (in_array($id, $arrayPolls)) {
    exit();
  }
}


// ìàññèâ, êîòîðûé áóäåì âîçâðàùàòü êëèåíòó
$result = array();

// åñëè ôàéëàìè ñ ðåçóëüòàòàìè íåò
if (!file_exists($nameFile)) {
  // ðåçóëüòèðóþùèé ìàññèâ
  $output = array();
  // ìàññèâ äëÿ õðàíåíèÿ îòâåòîâ
  $answers = array();
  // çàïîëíÿåì ìàññèâ íóëÿìè
  for ($i=0; $i<=$count-1; $i++) {
    $answers[$i] = 0;
  }
  // óâåëè÷èâàåì â ìàññèâå ïîëó÷åííûé ýëåìåíò íà 1
  $answers[$answer-1] = $answers[$answer-1] + 1;
  // ñâÿçûâàåì id îïðîñà ñ îòâåòàìè   
  $output[$id] = $answers;
  // êîäèðóåì àññîöèàòèâíûé ìàññèâ â JSON
  $output = json_encode($output);
  // çàïèñûâàåì â ôàéë
  file_put_contents(dirname(__FILE__).'/'.$nameFile, $output, LOCK_EX);
} else {
  // ïîëó÷àåì ñîäåðæèìîå ôàéëà
  $output = file_get_contents(dirname(__FILE__).'/'.$nameFile);
  // äåêîäèðóåì ñîäåðæèìîå â ìàññèâ
  $output = json_decode($output, true);
  // ïðîâåðÿåì åñòü åñëè óêàçàííûé êëþ÷ ãîëîñîâàíèÿ â àññîöèàòèâíîì ìàññèâå
  if (array_key_exists($id, $output)) {
    // ïîëó÷àåì çíà÷åíèå, ñâÿçàííîå ñ óêàçàííûì êëþ÷îì
    $answers = $output[$id];
    // óâåëè÷èâàåì â ìàññèâå ïîëó÷åííûé ýëåìåíò íà 1
    $answers[$answer-1] = $answers[$answer-1] + 1;
    // ïåðåçåïèñûâàåì ìàññèâ îòâåòîâ, ñâÿçàííûõ ñ êëþ÷îì
    $output[$id] = $answers;
  } else {
    /* åñëè íå íàéäåí ïåðåäàííûé êëþ÷ â ìàññèâå */
    // ìàññèâ äëÿ õðàíåíèÿ îòâåòîâ
    $answers = array();
    // çàïîëíÿåì ìàññèâ íóëÿìè
    for ($i=0; $i<=$count-1; $i++) {
      $answers[$i] = 0;
    }
    // óâåëè÷èâàåì â ìàññèâå ïîëó÷åííûé ýëåìåíò íà 1
    $answers[$answer-1] = $answers[$answer-1] + 1;
    // äîáàâëÿåì â ðåçóëüòèðóþùèé ìàññèâ êëþ÷îì è ñâÿçàííûé ñ íèì àññîöèàòèâíûé ìàññèâ
    $output[$id] = $answers;
  }
  // êîäèðóåì àññîöèàòèâíûé ìàññèâ â JSON
  $output = json_encode($output);
  // çàïèñûâàåì â ôàéë
  file_put_contents(dirname(__FILE__).'/'.$nameFile, $output, LOCK_EX);
}

if (isset($_COOKIE['polls'])) {
  $arrayPolls = explode(',',$_COOKIE['polls']);
} else {
  $arrayPolls = array();
}
array_push($arrayPolls,$id);
setcookie('polls', implode(',',$arrayPolls),time() + (86400 * 365),'/');   

$result[$id] = $answers;
$result = json_encode($result);  
echo $result;
exit();
?>
