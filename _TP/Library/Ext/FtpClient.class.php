<?php

namespace Ext;

/**
 * usage
 *
 * @author eamonning
 *
 *         $this->load->library ( 'ftp' );
 *         if ($error = $this->ftp->open ( "host", 'port', 'username', 'passwd' )) {
 *         exit ( $error );
 *         }
 *         $this->ftp->pasv ( true );
 *         print_r ( $this->ftp->ls ( '/' ) );
 *         if ($this->ftp->is_dir ( '/a/' )) {
 *         echo '/a/ is dir';
 *         } else {
 *         echo '/a/ is not dir';
 *         }
 *         echo "\n";
 *         if ($this->ftp->is_dir ( '/79w.com/' )) {
 *         echo '/79w.com/ is dir';
 *         } else {
 *         echo '/79w.com/ is not dir';
 *         }
 *         $this->ftp->mkdir ( '/what/a/nice/day/' );
 *         if ($error = $this->ftp->put (  'index.php', '/usr/test/dir/index.php' )) {
 *         exit ( $error );
 *         }
 *         if ($error = $this->ftp->get ( '/usr/test/dir/index.php', 'get/file/put/index.php' )) {
 *         exit ( $error );
 *         }
 */
class FtpClient
{
    private $conn = null;

    function __construct()
    {
    }

    function __destruct()
    {
        $this->close();
    }

    /**
     * open ftp connection
     *
     * @param string $host
     * @param string $port
     * @param string $user
     * @param string $passwd
     * @return null on success, error string will return on failed
     */
    function open($host, $port, $user, $passwd)
    {
        $this->conn = @ftp_connect($host, $port);
        if (!$this->conn) {
            $this->conn = null;
            return "Failed to connect to ftp server [$host:$port] :(";
        }
        if (!@ftp_login($this->conn, $user, $passwd)) {
            @ftp_close($this->conn);
            $this->conn = null;
            return "Failed to login ftp server [user:$user,passwd:$passwd] :(";
        }
        $this->pasv(true);
        return null;
    }

    /**
     * close ftp connection
     *
     * @return none
     */
    function close()
    {
        if ($this->conn) {
            @ftp_close($this->conn);
            $this->conn = null;
        }
    }

    /**
     * enable or disable pasv mode
     *
     * @param boolean $enable
     */
    function pasv($enable = true)
    {
        if ($this->conn) {
            ftp_pasv($this->conn, $enable);
        }
    }

    /**
     * list file list in remote path
     *
     * @param string $remote_path
     */
    function ls($remote_path)
    {
        if ($this->conn) {
            $ls = ftp_nlist($this->conn, $remote_path);
            if (is_array($ls)) {
                return $ls;
            }
        }
        return array();
    }

    /**
     * check if a path is dir
     *
     * @param string $dir
     * @return boolean
     */
    function is_dir($dir)
    {
        if ($this->conn) {
            $original_directory = ftp_pwd($this->conn);
            if (@ftp_chdir($this->conn, $dir)) {
                if ($original_directory) {
                    @ftp_chdir($this->conn, $original_directory);
                }
                return true;
            }
        }
        return false;
    }

    /**
     * ensure directory path
     *
     * @param string $directory
     */
    function mkdir($dir)
    {
        if ($this->conn) {
            $dir = trim(str_replace("\\", "/", $dir));
            if (!$this->is_dir($dir)) {
                $dirs = explode("/", $dir);
                $curr = '';
                for ($i = 0; $i < count($dirs); $i++) {
                    if ($dirs [$i]) {
                        $curr .= '/' . $dirs [$i];
                        if (!$this->is_dir($curr)) {
                            @ftp_mkdir($this->conn, $curr);
                        }
                    }
                }
            }
        }
    }

    /**
     * check if remote exists specify file
     *
     * @param string $remote_path
     */
    function exists($remote_path)
    {
        if ($this->conn) {
            if (ftp_nlist($this->conn, $remote_path)) {
                return true;
            }
        }
        return false;
    }

    /**
     * upload local file to ftp server
     *
     * @param string $local_path
     *            : MUST be full path
     * @param string $remote_path
     *            : MUST be full path
     * @return string error string will return if error occurs
     */
    function put($local_path, $remote_path)
    {
        if ($this->conn) {
            $this->mkdir(dirname($remote_path));
            if (!@ftp_put($this->conn, $remote_path, $local_path, FTP_BINARY)) {
                return "Failed to put file '$local_path' => '$remote_path' :(";
            }
            return null;
        } else {
            return 'No ftp server was connect :(';
        }
    }

    /**
     * get remote file to local
     *
     * @param string $remote_path
     *            : MUST be full path
     * @param string $local_path
     *            : MUST be full path
     * @return string NULL
     */
    function get($remote_path, $local_path)
    {
        if ($this->conn) {
            @mkdir(dirname($local_path), 0777, true);
            if (!@ftp_get($this->conn, $local_path, $remote_path, FTP_BINARY)) {
                return "Failed to get file '$remote_path' => '$local_path' :(";
            }
            return null;
        } else {
            return 'No ftp server was connect :(';
        }
    }
}