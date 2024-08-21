<?php

namespace App\Modules\Sgd\Models;

use Higgs\Model;
use Config\Database;

/**
* Ej: $model = model('App\Modules\Sgd\Models\Sgd_Series');
* @method where(mixed $primaryKey, string $id) : \Higgs\Database\BaseBuilder
* @method groupStart() : \Higgs\Database\BaseBuilder
*/
class Sgd_Series extends Model
{
protected $table = "sgd_series";
protected $primaryKey = "serie";
protected $returnType = "array";
protected $useSoftDeletes = true;
protected $allowedFields = [
	       "serie",
	       "name",
	       "description",
	       "author",
	       "created_at",
	       "updated_at",
	       "deleted_at",
];
protected $beforeFind = ['_exec_BeforeFind'];
protected $afterFind = ['_exec_FindCache'];
protected $afterInsert = ['_exec_UpdateCache'];
protected $afterUpdate = ['_exec_UpdateCache'];
protected $afterDelete = ['_exec_DeleteCache'];
protected $useTimestamps = true;
protected $createdField = "created_at";
protected $updatedField = "updated_at";
protected $deletedField = "deleted_at";
protected $validationRules = [];
protected $validationMessages = [];
protected $skipValidation = false;
protected $DBGroup = "authentication";//default
protected $version = '1.0.0';
protected $cache_time = 60;
protected $cache;
/**
* Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
**/
public function __construct()
{
parent::__construct();
$this->exec_TableRegenerate();
}
public function get_CountAllResults($search = "")
{
if (!empty($search)) {
$result = $this
->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')
->select('cadastre_customers.*, cadastre_profiles.*')
->groupStart()
->like("cadastre_customers.customer", "%{$search}%")
->orLike("cadastre_customers.registration", "%{$search}%")
->groupEnd()
->orderBy("cadastre_customers.registration", "DESC")
->countAllResults();
} else {
$result = $this
->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')
->select('cadastre_customers.*, cadastre_profiles.*')
->orderBy("cadastre_customers.registration", "DESC")
->countAllResults();
}
return ($result);
}
/**
* Regenera o recrea la tabla de la base de datos en caso de que esta no exista
* Ejemplo de campos
* $fields = [
*      'id'=> ['type'=>'INT','constraint'=> 5,'unsigned'=> true,'auto_increment' => true],
*      'title'=>['type'=> 'VARCHAR','constraint'=>'100','unique'  => true,],
*      'author'=>['type'=>'VARCHAR','constraint'=> 100,'default'=> 'King of Town',],
*      'description'=>['type'=>'TEXT','null'=>true,],
*      'status'=>['type'=>'ENUM','constraint'=>['publish','pending','draft'],'default'=>'pending',],
*   ];
* Ejemplo de keys
* $forge->addPrimaryKey('id');
* $forge->addKey('title');
* $forge->addUniqueKey(['product', 'discount']); 
*/
private function exec_TableRegenerate()
{
if (!$this->get_TableExist()) {
$forge = Database::forge($this->DBGroup);
$fields = [
			 'serie' => ['type' => 'VARCHAR','constraint' =>13, 'null' => FALSE],
			 'name' => ['type' => 'VARCHAR','constraint' =>254, 'null' => FALSE],
			 'description' => ['type' => 'TEXT', 'null' => FALSE],
'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
'created_at' => ['type' => 'DATETIME', 'null' => TRUE],
'updated_at' => ['type' => 'DATETIME', 'null' => TRUE],
'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE],
];
$forge->addField($fields);
$forge->addPrimaryKey($this->primaryKey);
$forge->addKey('author');
$forge->createTable($this->table, TRUE);
}
}

/**
		 * Retorna falso o verdadero si el usuario activo ne la sesión es el
		 * autor del registro que se desea acceder, editar o eliminar.
		 * @param string $id código primario del registro a consultar
		 * @param string $author código del usuario del cual se pretende establecer la autoría
		 * @return boolean falso o verdadero según sea el caso
		 */
		public function get_Authority(string $id, string $author): bool
		{
				$key = $this->get_CacheKey("{$id}{$author}");
				$cache = cache($key);
				if (!$this->is_CacheValid($cache)) {
						$row = $this->where($this->primaryKey, $id)->first();
						if (isset($row["author"]) && $row["author"] == $author) {
								$value = true;
						} else {
								$value = false;
						}
						$cache = array('value' => $value, 'retrieved' => true);
						cache()->save($key, $cache, $this->cache_time);
				}
				return ($cache['value']);
		}
/**
		 * Obtiene una lista de registros con un rango especificado y opcionalmente filtrados por un término de búsqueda.
		 * con opciones de filtrado y paginación.
		 * @param int $limit El número máximo de registros a obtener por página.
		 * @param int $offset El número de registros a omitir antes de comenzar a seleccionar.
		 * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
		 * @return array|false		Un arreglo de registros combinados o false si no se encuentran registros.
		 */
		public function get_List(int $limit, int $offset, string $search = ""): array|false
		{
				$result = $this
						->groupStart()
						->like("serie", "%{$search}%")
						->orLike("name", "%{$search}%")
						->orLike("description", "%{$search}%")
						->orLike("author", "%{$search}%")
						->groupEnd()
						->orderBy("created_at", "DESC")
						->findAll($limit, $offset);
				if (is_array($result)) {
						return $result;
				} else {
						return false;
				}
		}
		 /**
		 * Retorna el listado de elementos existentes de forma que se pueda cargar un field tipo select.
		 * Ejemplo de uso:
		 * $model = model("App\Modules\Sie\Models\Sie_Modules");
		 * $list = $model->get_SelectData();
		 * $f->get_FieldSelect("list", array("selected" => $r["list"], "data" => $list, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
		 */
		 public function get_SelectData()
			 {
				 $result = $this->select("`{$this->primaryKey}` AS `value`,`name` AS `label`")->findAll();
				 if (is_array($result)) {
					 return ($result);
				 } else {
					 return (false);
				 }
		 }
/**
		 * Este método verifica si la tabla especificada existe en la base de datos utilizando la función tableExists()
		 * del objeto db de Higgs. Además, utiliza la caché para almacenar el resultado de la verificación para mejorar
		 * el rendimiento y evitar la sobrecarga de la base de datos. La clave de caché se crea utilizando el método
		 * get_CacheKey(), que se supone que retorna una clave única para la tabla especificada. El tiempo de duración de
		 * la caché se establece en el atributo $cache_time.
		 * @return bool Devuelve true si la tabla existe, false en caso contrario.
		 */
		private function get_TableExist(): bool
		{
				$cache_key = $this->get_CacheKey($this->table);
				if (!$data = cache($cache_key)) {
						$data = $this->db->tableExists($this->table);
						cache()->save($cache_key, $data, $this->cache_time);
				}
				return $data;
		}
/**
		 * Obtiene el número total de registros que coinciden con un término de búsqueda.
		 * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
		 * @return int Devuelve el número total de registros que coinciden con el término de búsqueda.
		 */
		function get_Total(string $search = ""): int
		{
				$result = $this
						->groupStart()
						->orLike("name", "%{$search}%")
						->orLike("description", "%{$search}%")
						->orLike("author", "%{$search}%")
						->groupEnd()
						->countAllResults();
				return ($result);
		}
/**
		 * Obtiene la clave de caché para un identificador dado.
		 * @param $product
		 * @return array|false
		 */
		public function get_Serie($serie):false|array
		{
				$key = $this->get_CacheKey("serie-{$serie}");
				$cache = cache($key);
				if (!$this->is_CacheValid($cache)) {
						$row = $this->where($this->primaryKey, $serie)->first();
						if (is_array($row)) {
								$value = $row;
						} else {
								$value = false;
						}
						$cache = array('value' => $value, 'retrieved' => true);
						cache()->save($key, $cache, $this->cache_time);
				}
				return ($cache['value']);
		}
/**
		 * Método is_CacheValid
		 * Este método verifica si los datos recuperados de la caché son válidos.
		 * @param mixed $cache - Los datos recuperados de la caché.
		 * @return bool - Devuelve true si los datos de la caché son válidos, false en caso contrario.
		 */
		private function is_CacheValid(mixed $cache): bool
		{
				return is_array($cache) && array_key_exists('retrieved', $cache) && $cache['retrieved'] === true;
		}
/**
* Obtiene la clave de caché para un identificador dado.
* @param mixed $id Identificador único para el objeto en caché.
* @return string Clave de caché generada para el identificador.
**/
protected function get_CacheKey($id)
{
$id = is_array($id) ? implode("", $id) : $id;
$node = APPNODE;
$table = $this->table;
$class = urlencode(get_class($this));
$version = $this->version;
$key = "{$node}-{$table}-{$class}-{$version}-{$id}";
return md5($key);
}
private function get_CachedItem($id)
{
$cacheKey = $this->get_CacheKey($id);
$cachedData = cache($cacheKey);
return $cachedData !== null ? $cachedData : false;
}
protected function _exec_BeforeFind(array $data)
{
if (isset($data['id']) && $item = $this->get_CachedItem($data['id'])) {
$data['data'] = $item;
$data['returnData'] = true;
return $data;
}
}
protected function _exec_FindCache(array $data)
{
$id = $data['id'] ?? null;
cache()->save($this->get_CacheKey($id), $data['data'], $this->cache_time);
return ($data);
}
/**
* Implementa la lógica para actualizar la caché después de insertar o actualizar
* Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind
* y guardar los datos en la caché usando cache().
* @param array $data
* @return void
*/

protected function _exec_UpdateCache(array $data)
{
$id = $data['id'] ?? null;
if ($id !== null) {
$updatedData = $this->find($id);
if ($updatedData) {
cache()->save($this->get_CacheKey($id), $updatedData, $this->cache_time);
}
}
}
/**
* Implementa la lógica para eliminar la caché después de eliminar
* Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind
* para invalidar la caché.
* @param array $data
* @return void
*/
protected function _exec_DeleteCache(array $data)
{
$id = $data['id'] ?? null;
if ($id !== null) {
$deletedData = $this->find($id);
if ($deletedData) {
cache()->delete($this->get_CacheKey($id));
}
}
}
}

?>