<?php
isset($_GET['id']) ? $id = $_GET['id'] : exit('error');

require '../tools/modelList.php';
require '../tools/modelTextures.php';

$modelList = new modelList();
$modelTextures = new modelTextures();

$id = explode('-', $id);
$modelId = (int)$id[0];
$modelTexturesId = isset($id[1]) ? (int)$id[1] : 0;

$modelName = $modelList->id_to_name($modelId);
$modelTexturesList = is_array($modelName) ? ['textures' => $modelName] : $modelTextures->get_list($modelName);
$modelTexturesNewId = $modelTexturesId == 0 ? 2 : $modelTexturesId + 1;
if (!isset($modelTexturesList['textures'][$modelTexturesNewId-1])) $modelTexturesNewId = 1;

header("Content-type: application/json");
echo json_encode(array('textures' => array(
    'id' => $modelTexturesNewId,
    'name' => $modelTexturesList['textures'][$modelTexturesNewId-1],
    'model' => is_array($modelName) ? $modelName[$modelTexturesNewId-1] : $modelName
)), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
