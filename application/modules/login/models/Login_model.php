<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login_model extends CI_Model
{
    public function login($user_name, $password)
    {
        $access = false;
        
        $sql='SELECT
					SU.userid,
					SU.user_name,
					SU.nama_lengkap,
					SU.user_group,
					SU.online,
					SU.alamat,
					SU.daerah,
					SU.no_hp,
                    SU.tgl_last_login

				FROM sys_user SU
				WHERE
                    SU.user_name = '.$user_name.' 
					AND SU.password = md5(sha1('.$password.'))
					AND SU.aktif="y"';

        $result = $this->db->query($sql)->row();
        if (isset($result)) {
            // $sql_ol = "UPDATE m_user set online='y' where username='".$this->username."'";
            // $result_ol = $this->db->query($sql_ol);
        
            $token = md5(sha1(crc32($result->userid.$result->user_name.date('Y-m-d h:i:s'))));

            $access = true;
            $data = array(
                    'token' => $token,
                    'userid' => $result->userid,
                    'user_name' => $result->user_name,
                    'nama_lengkap' => $result->nama_lengkap,
                    'user_group' => $result->user_group,
                    'alamat' => $result->alamat,
                    'daerah' => $result->daerah,
                    'no_hp' => $result->no_hp,
                    'tgl_last_login' => $result->tgl_last_login,
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'logged_in'     => true,
            );
            $this->session->set_userdata($data);
            $this->update_user_token($result->userid, $token);
        }
        return $access;
    }

    public function update_user_token($userid, $token)
    {
        $result = FALSE;
        if ($userid != "") {
            $data = array(
                'token'=> $token,
                'tgl_last_login'=> date('Y-m-d H:i:s'),
            );
            $this->db->where('userid', $userid);
            $this->db->update('sys_user', $data);
            $result = TRUE;
        }

        return $result;
    }

    public function check_password($id, $password1, $password2, $password3)
    {
        $result = false;
        if ($password1 != $this->db->escape('')) {
            if ($password2 != $this->db->escape('') && $password3 != $this->db->escape('')) {
                $sql = 'SELECT userid,user_name FROM sys_user WHERE password=md5(sha1(crc32('.$password1.'))) AND userid='.$id;
                $check = $this->db->query($sql)->row();
                if (isset($check)) {
                    $result = true;
                }
            }
        }

        return $result;
    }

    public function change_password($id, $password1, $password2, $password3)
    {
        $result = false;
        if ($password2 == $password3) {
            if ($password2 != $this->db->escape('') && $password3 != $this->db->escape('')) {
                if ($id) {
                    $sql = 'UPDATE sys_user SET password=md5(sha1(crc32('.$password2.'))) WHERE userid='.$id;
                    $result = $this->db->query($sql);
                }
            }
        }
        
        return $result;
    }

    public function logout()
    {
        $data = array(
            'userid',
            'user_name',
            'nama_lengkap',
            'user_group',
            'tgl_last_login',
            'alamat',
            'daerah',
            'no_hp',
            'ip',
            'logged_in',
            'lockscreen',
        );
        $this->session->unset_userdata($data);
    }
}
