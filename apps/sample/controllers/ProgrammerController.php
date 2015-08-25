<?php
namespace Sample\Controller;


use Slimvc\Core\Controller;
use Sample\Model\ProgrammerModel;

class ProgrammerController extends Controller
{
    /**
     * Get programmers with pagination and field filtering support,
     * Example urls,
     *  - http://slimvc.dev/v1/programmers
     *  - http://slimvc.dev/v1/programmers?fields=id,name&start=1&limit=2
     *  - http://slimvc.dev/v1/programmers?fields=id,name&start=4&limit=2
     */
    public function actionGetProgrammers()
    {
        $start = (int)$this->getApp()->request()->get('start', 0); // zero based offset
        $limit = (int)$this->getApp()->request()->get('limit', 10);
        $fieldsStr = $this->getApp()->request()->get('fields', '');

        $fields = explode(',', $fieldsStr);
        foreach ($fields as $key => $field) {
            $field = trim($field);
            if (!$field) {
                unset($fields[$key]);
            }
            // TODO do safety check for fields
        }

        $programmerModel = new ProgrammerModel();
        if (!$result = $programmerModel->getAllProgrammers($fields, $start, $limit)) {
            $result = array();
        }

        echo json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Get programmer by id
     * Example url,
     *  - http://slimvc.dev/v1/programmers/1
     *  - http://slimvc.dev/v1/programmers/1?fields=id,name
     *
     * @param integer $id The programmer id
     */
    public function actionGetProgrammer($id)
    {
        $fieldsStr = $this->getApp()->request()->get('fields', '');

        $fields = explode(',', $fieldsStr);
        foreach ($fields as $key => $field) {
            $field = trim($field);
            if (!$field) {
                unset($fields[$key]);
            }
            // TODO do safety check for fields
        }

        $programmerModel = new ProgrammerModel();
        if (!$result = $programmerModel->getProgrammer($id, $fields)) {
            $this->getApp()->status(404);
            $result = array(
                'code' => 404,
                'message' => 'specified programmer is not found'
            );
        }

        echo json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
