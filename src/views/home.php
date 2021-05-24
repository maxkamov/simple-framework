<?php
use app\core\widgets\TableHeaderWidget;
use app\models\entities\Task;
?>


<h1>Список задач</h1>

<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <?php (new TableHeaderWidget([
                'label'=>'Имя',
                'column_name'=> 'username',
                'queryParams' => $queryParams
            ]))->run(); ?>
            <?php (new TableHeaderWidget([
                'label'=>'Текст',
                'column_name'=> 'text',
                'queryParams' => $queryParams
            ]))->run(); ?>
            <?php (new TableHeaderWidget([
                'label'=>'Почта',
                'column_name'=> 'Email',
                'queryParams' => $queryParams
            ]))->run(); ?>
            <?php (new TableHeaderWidget([
                'label'=>'Статус',
                'column_name'=> 'status',
                'queryParams' => $queryParams
            ]))->run(); ?>
            <th>Действия</th>
        </tr>
        <?php foreach ($dataProvider->getData() as $model): ?>
            <tr>
                <td><?= $model['username'] ?></td>
                <td><?= $model['text'] ?></td>
                <td><?= $model['email'] ?></td>
                <td><?= Task::getTaskStatus($model['status'],$model['updated_by']) ?></td>
                <td><a href="/task-edit?id=<?= $model['id'] ?>" class="btn btn-success">Редактировать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php (new \app\core\widgets\PaginationWidget(
    $dataProvider->getTotalRecords(),
    $dataProvider->getPageSize(),
    $dataProvider->getCurrentPage(),
    $queryParams))->run() ?>