<?php
use MyNamespace\Core\ModelAbstract;

class ArticleModel extends ModelAbstract
{
    public function getById($id)
    {
        // TODO related DML lines here
        $dbh = $this->getReadConnection();

        return array(
            'id' => $id,
            'title' => 'title for article '. $id,
            'content' => 'content for article '. $id,
        );
    }

    public function delete($id)
    {
        // TODO related DML lines here
        $dbh = $this->getWriteConnection();

        return true;
    }
}