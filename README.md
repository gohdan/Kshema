Kshema
======

Free and open source CMS/CMF


=== Install ===

1. Copy all files to web server.

2. Copy themes/default to your own theme (for example, themes/sample).

3. Change themes/sample/db_config.php according to your hosting parameters.

4. In config.php change include to your own theme.

5. Go to /base/install . It will create some necessary tables and admin account. Take the password it will gave to you, login value is the value of $config['base']['admin_email']
