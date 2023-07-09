---
layout:
  title:
    visible: true
  description:
    visible: true
  tableOfContents:
    visible: true
  outline:
    visible: true
  pagination:
    visible: false
---

# Загрузка медиа-файлов

## Пример загрузки медиа-файлов

```php
$group_id = 'group_id';
$file = '/path/to/file.jpg';

$upload_server = $api->photos->getWallUploadServer(group_id: $group_id)->response->upload_url;
$upload = $api->upload($upload_server, $file);
$photo = $api->photos->saveWallPhoto($upload + ['group_id' => $group_id]);

$api->wall->post([
    'owner_id' => -$group_id,
    'attachments' => $photo->response[0]->id,
    'from_group' => 1,
]);
```
