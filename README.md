# Lexx-TPL

Lexx-TPL is a simple and easy-to-use TPL file processor for PHP.
It allows you to separate HTML templates from PHP logic and perform fast placeholder replacement, template inclusion, and fragment rendering.

---

## Features

* Simple placeholder replacement
* Template inclusion
* Fragment rendering with associative arrays
* Optional removal of unused placeholders
* Lightweight and easy to integrate

---

## Installation

1. Create a directory for the processor.
2. Copy the file `tpl-proc-04.php` into that directory.
3. Create a subdirectory where your `.tpl` template files will be stored.

Example structure:

```
project/
 ├── tpl-proc-04.php
 ├── templates/
 │    ├── main.tpl
 │    ├── menu.tpl
 └── index.php
```

---

## Usage

### 1. Include the processor

```php
require_once('dir_name/tpl-proc-04.php');
```

---

### 2. Create a template object

```php
$site = new tpl("your-template-name.tpl");
```

---

### 3. Set the template directory

```php
$site->set_template_dir("template_dir_location_and_name");
```

---

### 4. Replace placeholders

Call `set()` as many times as needed.

```php
$site->set("key", "value");
```

In a template file, placeholders are written like:

```
{example}
```

---

## Including Templates

To include another template inside a template, use:

```
{include=name.tpl}
```

Replace `name.tpl` with the file you want to include.

---

## Using Fragments

The `include_fragment()` function:

* Loads a fragment template
* Replaces placeholders
* Returns the generated HTML

Example:

```php
$site->set(
    "key_location",
    $site->include_fragment(
        "menu.tpl",
        [
            "key_home" => "Home",
            "key_services" => "Services"
        ]
    )
);
```

Explanation:

* `key_location` → placeholder in the main template
* `include_fragment()` → returns the processed HTML fragment

---

## Rendering Output

Display the final result:

```php
echo $site->exe();
```


## Removing Unused Placeholders

The `exe()` function accepts an optional boolean parameter.

If set to `true`, all placeholders that were not replaced will be removed.

```php
echo $site->exe(true);
```

Default behavior:

```php
echo $site->exe(false);
```

## Example

```php
require_once('tpl-proc-04.php');

$site = new tpl("main.tpl");
$site->set_template_dir("templates");

$site->set("title", "My Website");
$site->set("content", "Hello world!");

echo $site->exe();
```
