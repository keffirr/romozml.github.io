<?php
$nameFile = 'poll-results.txt';
$current = 'pool-2';

$votes = array();

// pool-1
$key = 'pool-1';
$value = new stdClass();
$value->id = $key;
$value->question = 'Какая стихия вам ближе?';
$value->answers = array('Огонь','Воздух','Вода','Земля');
$votes[$key]=$value;

// pool-2
$key = 'pool-2';
$value = new stdClass();
$value->id = $key;
$value->question = 'Какой ваш любимый цвет?';
$value->answers = array('Красный','Оранжевый','Зелёный','Синий','Нет, другой');
$votes[$key]=$value;


/* блок для вывода результатов если пользователь проголосовал */
if (isset($_COOKIE['polls'])) {
  $arrayPolls = explode(',',$_COOKIE['polls']);
  if (in_array($current, $arrayPolls)) {
    // получаем содержимое файла
    $output = file_get_contents(dirname(__FILE__).'/'.$nameFile);
    // декодируем содержимое в массив
    $output = json_decode($output, true);
    // проверяем есть если указанный ключ голосования в ассоциативном массиве
    if (array_key_exists($current, $output)) {
      // получаем значение, связанное с указанным ключом
      $votes[$current]->result = $output[$current];
    }
  }
}

echo json_encode($votes[$current]);

exit();
