<?php

class DAE
{
    private static function oracle($sql)
    {
        $connection = ssh2_connect(ssh_host, ssh_port);

        if (ssh2_auth_password($connection, ssh_user, ssh_pass)) {
            $conttStream = ssh2_exec($connection, 'source .bash_profile; echo "' . $sql . '" | sqlplus -M "HTML ON" ' . orcl);

            $errorStream = ssh2_fetch_stream($conttStream, SSH2_STREAM_STDERR);

            stream_set_blocking($errorStream, true);
            stream_set_blocking($conttStream, true);

            $error = stream_get_contents($errorStream);
            if ($error != "") {
                return "Error: " . $error;
            }

            $contt = stream_get_contents($conttStream);
            if ($contt != "") {
                preg_match_all('/SQL&gt;(.*)SQL&gt;/s', $contt, $content);
                return $content[1][0];
            }

            fclose($errorStream);
            fclose($conttStream);
        }
        
    }
    
    public static function oracle2mysql($sql){
        preg_match_all('/<tr>(.*?)<\/tr>/s', utf8_encode(self::oracle($sql)), $content);
        $results_table = $content[0];
        $thead = array_shift($results_table);
        $tbody = "";
        foreach ($results_table as $rt) {
            if ($rt != $thead) {
                $tbody .= $rt;
            }
        }
        $content1 =  str_replace('</td></tr>','"),',str_replace('</td><td>','","',str_replace('<tr><td>','(default,"',preg_replace('/ ¿| align="right"|( ){2,}|\r|\n|\t/', '', $tbody))));
        
        return rtrim($content1,',');
    }

    public static function firebird(){
        try {
            return new PDO(fbfdsn, fbuser, fbpass);
        } catch (PDOException $e) {
            return "ERROR: " . $e->getMessage();
        }        
    }
}
