<?php
echo "ODBC_ALLOW_INSECURE_TLS = " . (getenv('ODBC_ALLOW_INSECURE_TLS') ?: 'NÃO DEFINIDO');
echo "\n<br>\n";
phpinfo();