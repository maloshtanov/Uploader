# uploader
Simple model attachment uploader and autodelete attachments with delete model records

## Installation

### Step 1: Install the package

Install the package via Composer:

```
composer require maloshtanov/uploader
```

### Step 2: Publish the package config file

```
php artisan vendor:publish --provider="Maloshtanov\Uploader\UploaderServiceProvider"
```

### Step 3: Update needed models

Add attachment support to your models by using the AttachmentAutoDelete trait:

```php
class ... extends Model {
    use Maloshtanov\Uploader\Traits\AttachmentAutoDelete;
}
```
## Usage

Will be later
