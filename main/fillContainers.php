<?php
/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 12.04.2018
 * Time: 9:33
 */
namespace main;

include_once "../vendor/autoload.php";

$itemsSize = $_POST['items'];
$weights = preg_split('#\s+#', $itemsSize);
$algorithmType = "main\\" . trim($_POST['algorithmType']);
$type = $_POST['type'];


if ($type == 'unsorted') {
    $algorithm = new UnsortedAlgorithm(new $algorithmType($weights));
} else {
    $algorithm = new SortedAlgorithm(new $algorithmType($weights));
}
list('countContainers' => $countElem, 'countComparisons' => $count) = $algorithm->executeAlgorithm();
$listContainers = $algorithm->getStrategy()->getListContainers();
$list = [];
foreach ($listContainers as $container) {
    $items = [];
    foreach ($container->getItems() as $item) {
        $items[] = $item->getItemSize();
    }
    $list[] = $items;
}
//min необходимое число контейнеров для упаковки груза
$minCountContainers = $algorithm->getStrategy()->minCountContainers();

echo json_encode(['countContainers' => $countElem, 'countComparisons' => $count,
    'listContainers' => $list, 'minCountContainers' => $minCountContainers]);

