# Simple-QueryBuilder

## Installation

### 1. First of all, connect the file "Connection.php" and create an object of this class. 

```php
require 'QueryBuilder/Connection/Connection.php';
$connection = new Connection('mysql:host=localhost', 'test', 'utf8', 'user', 'secret');
```

### 2. Connect the file "SQLBuilder.php" and create an object of this class.

```php
require 'QueryBuilder/SQLBuilder.php';
$sql_builder = new SQLBuilder();
```

### 3. Connect the file "QueryBuilder.php" and create an object of this class.

```php
require 'QueryBuilder/QueryBuilder.php';
$db = new QueryBuilder($connection, $sql_builder);
```

## Usage

### Retrieve all records
```php
$users = $db -> get_all('users');
```

### Retrieve record by id
```php
$user = $db -> get_one('users', 1);
```

### Retrieve record with params by id
```php
$user_email = $db -> get_params_by_id('users', ['email', 'nickname'], 1);
```

### Insert
```php
$db -> add('users', [
    'name' => 'john',
    'email' => 'john@example.com'
]);
```

### Update by id
```php
$db -> update('users', 
['name' => 'Jane',
 'email' => 'jane@example.com'
], 1);
```

### Delete by id 
```php
$db -> delete('users', 1);
```