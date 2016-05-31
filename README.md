# PHPMysqliDbConnectivity

### Usage:

* `require 'db.php' `

* change HOSTNAME, USERNAME, PASSWORD AND DBNAME in db.php file

* Create a database object  `$db = new Database();`
  
* Get Table data `$db->('table_name');`
  
  
### Functions:

  **raw_query($sql)**
  
      parameters: string
  
      returns: mysqli result object
  
  **get( 'table_name', $where=array('column_name'=>'value') )**
  
      parameters: string, array('key'=>'value')
  
      returns: single row element
  
  
  **get_all( 'table_name', $fields=array('id', 'name'), $where=array('column_name'=>'value'), $mixed=array('limit'=>0,'offset'=>0) )**
  
      parameters: string, array, array, array
    
      returns : array of rows 
    
  
  **insert()**
  
      parameters: string, 
  
      returns: 
  
  **update:**
  
      parameters: 
      
      returns: 
  
  **delete**
  
      parameters: 
      
      returns: 
      
