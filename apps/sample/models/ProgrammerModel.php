<?php
namespace Sample\Model;


use Slimvc\Core\Model;

class ProgrammerModel extends Model
{
    /**
     * Get programmers with pagination and field filtering support,
     *
     * @param array $fields the fields to be return
     * @param int $offset the offset position of programmers to be return
     * @param int $limit the numbers of programmers to be return
     *
     * @return array|static[]
     */
    public function getAllProgrammers($fields = array(), $offset = 0, $limit = 10)
    {
        // TODO: we just using PDO for example here, a DAL(Database Access Layer) is strongly recommended

        if ($fields && is_array($fields)) {
            // make sure the dynamical fields are safe
            foreach ($fields as $key => $field) {
                $fields[$key] = "`" . str_replace("`", "``", $field) . "`";
            }
            unset($key, $field);
            $fieldsStr = join(',', $fields);
        } else {
            $fieldsStr = '*';
        }

        $sql = 'SELECT ' . $fieldsStr . ' FROM `programmers`';

        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit;
        }

        if ($offset) {
            $sql .= ' OFFSET ' . (int)$offset;
        }

        $sth = $this->getReadConnection()->query($sql);
        $sth->setFetchMode(\PDO::FETCH_ASSOC);

        return $sth->fetchAll();
    }

    /**
     * Get programmer by id
     *
     * @param int $id the programmer id
     * @param array $fields the fields to be return
     *
     * @return mixed|static
     */
    public function getProgrammer($id, $fields = array())
    {
        // TODO: we just using PDO for example here, a DAL(Database Access Layer) is strongly recommended

        if ($fields && is_array($fields)) {
            // make sure the dynamical fields are safe
            foreach ($fields as $key => $field) {
                $fields[$key] = "`" . str_replace("`", "``", $field) . "`";
            }
            unset($key, $field);
            $fieldsStr = join(',', $fields);
        } else {
            $fieldsStr = '*';
        }

        $sql = 'SELECT ' . $fieldsStr . ' FROM `programmers` WHERE id = ? LIMIT 1';
        $sth = $this->getReadConnection()->prepare($sql);
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        $sth->execute(array(intval($id)));

        return $sth->fetch();
    }
}
