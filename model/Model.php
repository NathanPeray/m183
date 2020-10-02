<?php
    class Model {

        private static $stmt;

        public function __construct($data) {

            if (!isset($data['id'])) {
                $this->fromAssoc($data, false);
                $this->insert($this);
            } else {
                $this->fromAssoc($data);
            }
        }
        function save() {
            return Database::getInstance()->update($this);
        }
        static function get($id = null) {
            return $id ? Database::getInstance()->select(get_called_class(), $id)[0] : Database::getInstance()->select(get_called_class(), $id);
        }
        static function getAll() {
            return Database::getInstance()->select(get_called_class());
        }
        static function getFromUser() {
            return Database::getInstance()->selectFromUser(get_called_class(), Auth::getInstance()->getUser()->id);
        }
        static function getFromAuth($id = null) {
            return Database::getInstance()->selectProtected(get_called_class(), $id);
        }
        private function insert($model) {
            $modelName = get_called_class();
            if ($model instanceof $modelName) {
                return Database::getInstance()->insert($modelName, $model);
            } else {
                echo "INVALID MODEL";
            }
        }
        function delete() {
            return Database::getInstance()->delete(get_called_class(), $this->id);
        }
        function fromAssoc($assoc, $getForeign = true) {
            if ($assoc) {
                foreach ($assoc as $key => $attribute) {
                    if (strpos($key, "_FK") && $getForeign) {
                        $model = ucfirst(explode("_", $key)[0]);
                        $tmp =  $model::get($attribute);
                        $this->{strtolower($model)} = $tmp;
                    } else {
                        $this->{$key} = $attribute;
                    }
                }
            }
        }
        function getForeign($child) {
            $this->{strtolower($child) . "s"} = Database::getInstance()->selectForeign(get_called_class(), $child, $this->id);
        }
        function getProperties($getId = true) {
            if ($getId) {
                return get_object_vars($this);
            } else {
                $vars = get_object_vars($this);
                return array_splice($vars, 1);
            }
        }
    }
?>
