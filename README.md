# bawp

Importante: Este plugin ya no tiene soporte

**Documentación**

https://vivirenremoto.freshdesk.com/support/solutions/folders/61000016706

**Problemas**

Si no se cargan los resultados es posible que booking haya cambiado algo en su estructura HTML, en ese caso tendrás que revisar los scrapper:

- List.php esto scrapea un listado de resultados
- single.php esto scrapea una ficha de alojamiento

Nota: En la carpeta tests hay algunos scripts para probar si funcionan los scrappers, la forma de ejecutarlo sería entrando por navegador a la URL, por ejemplo:

http://wordpress.test/wp-content/plugins/bawp/tests/list.php
