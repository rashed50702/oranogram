<?php
/**
 * Model - All kind of database query and fetching result.  
 *
 *
 * PHP version 7.3
 *
 *
 * @category   CategoryName
 * @package    Organogram
 * @author     Sarwar Hossain <sarwar@instabd.com>
 * @copyright  2020 Intalogic Bangaldesh
 * @version    1.0.1
 */
namespace Organogram;

// Include the configration file 
include_once 'config.php';


/**
 * Model Class Statically use to all over the system.
 * Usage: \Model::get()->
 * 
 */
class Model{

    /**
     * @var MySQLi Object  
     */
    private $_dbcon;

    /**
     * Constructor 
     */
    public function __construct(){
        $this->_dbcon = new \MySQLi(env('DB_HOST', 'localhost'), env('DB_USER', 'dbuser'), env('DB_PASSWORD', 'password'), env('DB_NAME', 'dbname'));
        
        if ($this->_dbcon->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }
    
    
    /**
     * Static method get the Model Object 
     * @return \Organogram\Model
     */
    public static function get() {
        return new Model();
    }

    /**
     * Query : Execute the base query 
     * @param String $sql
     * @return mixed 
     */
    private function query($sql){
        return $this->_dbcon->query($sql);
    }
    
    /**
     * fetch : get the first result 
     * @param mixed $result
     * @return Array
     */
    private function fetch($result){
        $data = $result->fetch_assoc();
        $result->free_result();
        $this->_dbcon->close();
        return $data; 

    }
    /**
     * fetchAll : get the full result of query
     * @param type $result
     * @return type
     */
    private function fetchAll($result){        
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $result->free_result();
        $this->_dbcon->close();
        return $data; 
    }

    /**
     * employee: get the employee data
     * @param type $id
     * @return type
     */
    public function employees($id = false){
        $where = $id ? "WHERE id='{$id}'" : "";
        $sql= "SELECT * FROM employee {$where}"; 
        $result = $this->query($sql);
        $data = $this->fetchAll($result);
        return $data;
    }

    /**
     * ToDo:: // do something
     */
    public function roles(){
        // do something

    }
    
    /**
     * ToDo:: // do something
     */

    public function department(){
        $sql= "SELECT * FROM departments"; 
        $result = $this->query($sql);
        $data = $this->fetchAll($result);
        return $data; 
    }
    
    /**
     * ToDo:: // do something
     */

    public function employeeUnderMe($employeeId, $departmentId){

        // Construct a query to retrieve all employees with their roles and departments
            $employeeQuery = "SELECT e.id, e.name AS employee_name, e.email, r.name AS role_name, d.name AS department_name
                             FROM employee AS e
                             JOIN employee_roles AS er ON e.id = er.employee_id
                             JOIN roles AS r ON er.role_id = r.id
                             JOIN departments AS d ON er.department_id = d.id
                             WHERE r.parent_id = (
                                 SELECT role_id
                                 FROM employee_roles
                                 WHERE employee_id = $employeeId
                                 AND department_id = $departmentId
                             )
                             AND er.department_id = $departmentId";

            // Execute the query
            $employeeResult = $this->query($employeeQuery);

            if ($employeeResult) {
                // Fetch all employees with their roles and departments and store them in the result array
                $resultArray['employees'] = $this->fetchAll($employeeResult);
            }

            // Return the result array
            return $resultArray;

    }


    /**
     * employee: get the logged in employee data
     * @param type $id
     * @return type
     */
    public function login($email, $password, $departmentId){
        if (empty($email) || empty($password)) {
            return false; // Invalid input
        }

        $pass = trim($password);


        $sql = "SELECT e.*, ed.department_id
                FROM employee AS e
                INNER JOIN employee_departments AS ed ON e.id = ed.employee_id
                WHERE e.email = '$email' AND ed.department_id = $departmentId";

        $result = $this->query($sql);

        if ($result && $result->num_rows === 1) {

            $employee = $this->fetch($result);
            if (password_verify($pass, $employee['password'])) {
                return [
                    'id' => $employee['id'],
                    'email' => $employee['email'],
                    'department_id' => $employee['department_id']
                ];
            }else{
                return false; // Login failed, password did not match
            }
            
        } else {
            return false; // Login failed
        }

    }
}


