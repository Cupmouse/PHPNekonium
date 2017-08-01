# It is just a PHP Library to communicate with go-nekonium or alternative nothing special
## Requirements
* PHP 7.1
* PHP with curl and socket
* Make sure that the go-nekonium is already synced to network if you are using lib on mainnet. Because it takes some time to sync.

## How to
1. download lib
2. make dir named 'PHPNekonium' or something
3. put all files there from zipped lib except for .gitignore and Test.php
4. Run go-nekonium, if you want connect with RPC, then enable it (NOTE:personal_unlockAccount() cannot be called from RPC by default)
5. Run PHP 7.1 and web server
6. Write down your test.php like below
7. Open it with your favorite browser
7. YAY

```
<?php
    require_once 'PHPNekonium\NekoniumRPC.php';
    
    use kabayaki\PHPNekonium as Gnek;
    
    $gnek = new Gnek\NekoniumRPC("localhost", 8293);
    $result = $nek->eth_blockNumber();
    
    echo $result;
?>
```