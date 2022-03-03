<?php

class M_ora_medrec extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    function getMedrec($mr)
    {
        $sql = "SELECT
                    A.MR,
                    A.NAMA,
                    NVL(A.TEMPAT_LAHIR,'-') AS TEMPAT_LAHIR, 
                    TO_CHAR(A.TGL_LAHIR,'DD/MM/YYYY') AS TGL_LAHIR,
                    CASE WHEN A.ALAMAT = '' THEN '-'
                    ELSE
                        (A.ALAMAT || ' RT.' || A.RT || ' RW.' || A.RW || ' ' || A.KELURAHAN || ' ' || A.KECAMATAN || ' ' || A.KOTA) 
                    END AS ALAMAT 

                FROM
                    HIS_MANAGER.MS_MEDREC A
                WHERE
                    SUBSTR(A.MR,4) = '" . $mr . "'";

        $query = $this->oracle_db->query($sql);
        $row = $query->row();
        return $row;
    }

    function getEmployee($search)
    {
        $sql = "SELECT  
                    A.NAMA_KAR, 
                    A.NO_KAR, 
                    A.BAGIAN
                FROM 
                    HIS_MANAGER.MS_KARYAWAN A
                WHERE 
                    A.SHOW_ITEM = '1'
                    AND A.NAMA_KAR LIKE UPPER('" . $search . "'||'%')
                    AND ROWNUM <= 5
                ORDER BY A.NAMA_KAR ASC";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }

    function getTransPinjamMR()
    {
        $sql = "SELECT  
                   'TR' || SUBSTR(TO_CHAR(EDP_MANAGER.SEQ_PINJAM_MR.nextval, '000000'),2) AS NOMOR
                FROM 
                    DUAL";

        $query = $this->oracle_db->query($sql);
        $row = $query->row();
        return $row;
    }

    function savePinjamMR(
        $medrec,
        $nokar_peminjam,
        $keperluan,
        $dept_peminjam,
        $created_by,
        $diserahkan_oleh,
        $tgl_janji_kembali,
        $catatan
    )
    {
        $data[] = array(
            $medrec,
            $nokar_peminjam,
            $keperluan,
            $dept_peminjam,
            $created_by,
            $diserahkan_oleh,
            $tgl_janji_kembali,
            $catatan
        );
        $sql = "INSERT INTO  EDP_MANAGER.PINJAM_MR
        (
            MR, 
            NOKAR_PEMINJAM, 
            KEPERLUAN, 
            DEPT_PEMINJAM, 
            CREATED_DATE, 
            CREATED_BY, 
            DISERAHKAN_OLEH, 
            TGL_JANJI_KEMBALI, 
            CATATAN,
            SHOW_ITEM, 
            TRANS_PINJAM_MR
        )
        VALUES
        (
            '" . $medrec . "', 
            '" . $nokar_peminjam . "', 
            '" . $keperluan . "', 
            '" . $dept_peminjam . "', 
            SYSDATE, 
            '" . $created_by . "',
            '" . $diserahkan_oleh . "',
            SYSDATE,
            '" . $catatan . "',
            '1',
            'TR000148'
        )";
        $query = $this->oracle_db->query($sql);
        
        return $data;
    }
}
