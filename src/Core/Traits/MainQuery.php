<?php
/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/23/2023
 */


namespace Tusharkhan\FileDatabase\Core\Traits;

use Illuminate\Support\Carbon;

trait MainQuery
{

        /**
        * create
        *
        * @param  array $data
        * @return void
        */
        public static function create(array $data)
        {
            if (isset($data['id'])) {
                unset($data['id']);
            }

            $className = get_called_class();
            $model = new $className($data);

            return $model->save($data);
        }

        /**
        * save
        *
        * @return void
        */
        public function save()
        {
//            try {
//                $table = $this->objectTable();
//                foreach ($this->attribute as $key => $item) {
//                    $table->{$key} = $item;
//                }
//
//                if ($this->timestamp) {
//                    $table->created_at = (string) Carbon::now()->getTimestamp();
//                    $table->updated_at = (string) Carbon::now()->getTimestamp();
//                }
//
//                if ($this->attribute->id != null) {
//                    if ($this->timestamp) {
//                        unset($table->created_at);
//                    }
//                    $this->update((array) $this->attribute, $this->attribute->id);
//                } else {
//                    $table->save();
//                }
//                $this->id = $table->id;
//                $className = get_called_class();
//                return new $className($table);
//            } catch (\Exception $e) {
//                throw new \Exception($e->getMessage());
//            }
        }

        /**
        * update
        *
        * @param  array $data
        * @param  int $id
        * @return void
        */
        public function update(array $data, int $id)
        {
//            try {
//                $table = $this->objectTable();
//                $table = $table->find($id);
//                foreach ($data as $key => $item) {
//                    $table->{$key} = $item;
//                }
//                if ($this->timestamp) {
//                    $table->updated_at = (string) Carbon::now()->getTimestamp();
//                }
//                $table->save();
//                $className = get_called_class();
//                return new $className($table);
//            } catch (\Exception $e) {
//                throw new \Exception($e->getMessage());
//            }
        }

        /**
        * delete
        *
        * @param  int $id
        * @return void
        */
        public function delete(int $id)
        {
//            try {
//                $table = $this->objectTable();
//                $table = $table->find($id);
//                $table->delete();
//                return true;
//            } catch (\Exception $e) {
//                throw new \Exception($e->getMessage());
//            }
        }
}