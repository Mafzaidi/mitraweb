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
                    SUBSTR(TO_CHAR(EDP_MANAGER.SEQ_PINJAM_MR.nextval, '000000'),2) AS NOMOR
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
        $tgl_peminjaman,
        $tgl_janji_kembali,
        $trans_pinjam
    )
    {
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
                        TRANS_PINJAM_MR,
                        TGL_PINJAM
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
                        TO_DATE('" . $tgl_janji_kembali . "','DD.MM.RRRR'),
                        '" . $trans_pinjam . "',                      
                        TO_DATE('" . $tgl_peminjaman . "','DD.MM.RRRR')
                    )
                ";
        $query = $this->oracle_db->query($sql);
    }

    function updatePinjamMR(
        $trans_pinjam,
        $returnBy,
        $returnDesc,
        $receiveBy,
        $realReturnDate
    )
    {
        $sql = "UPDATE 
                    EDP_MANAGER.PINJAM_MR A
                SET
                    A.TGL_AKHIR_KEMBALI = TO_DATE('" . $realReturnDate . "','DD.MM.RRRR'),
                    A.DIKEMBALIKAN_OLEH = '" . $returnBy . "',
                    A.PETUGAS_PENERIMA = '" . $receiveBy . "',
                    A.CATATAN = '" . $returnDesc . "',
                    A.LAST_UPDATED_DATE = SYSDATE,
                    A.LAST_UPDATED_BY = '" . $receiveBy . "'
                WHERE
                    A.TRANS_PINJAM_MR = '" . $trans_pinjam . "'
                    AND A.TGL_AKHIR_KEMBALI IS NULL
                ";
        $query = $this->oracle_db->query($sql);
    }

    function updateSavedPinjamMR(
        $trans_id,
        $new_nik_peminjam,
        $new_tgl_pinjam,
        $new_keperluan,
        $new_tgl_kembali,
        $user
    )
    {
        $sql = "UPDATE 
                    EDP_MANAGER.PINJAM_MR A
                SET
                    A.NOKAR_PEMINJAM = '" . $new_nik_peminjam . "',
                    A.TGL_PINJAM = TO_DATE('" . $new_tgl_pinjam . "','DD.MM.RRRR'),
                    A.TGL_AKHIR_KEMBALI = TO_DATE('" . $new_tgl_kembali . "','DD.MM.RRRR'),
                    A.KEPERLUAN = '" . $new_keperluan . "',
                    A.LAST_UPDATED_DATE = SYSDATE,
                    A.LAST_UPDATED_BY = '" . $user . "'
                WHERE
                    A.TRANS_PINJAM_MR = '" . $trans_id . "'
                    AND A.TGL_AKHIR_KEMBALI IS NOT NULL
                ";
        $query = $this->oracle_db->query($sql);
    }

    function deletePinjamMR(
        $trans_pinjam,
        $deleteBy
    )
    {
        $sql = "UPDATE 
                    EDP_MANAGER.PINJAM_MR A
                SET
                    A.LAST_UPDATED_DATE = SYSDATE,
                    A.LAST_UPDATED_BY = '" . $deleteBy . "',
                    A.SHOW_ITEM = 0
                WHERE
                    A.TRANS_PINJAM_MR = '" . $trans_pinjam . "'
                    AND A.TGL_AKHIR_KEMBALI IS NULL
                ";
        $query = $this->oracle_db->query($sql);
    }

    function getRowPinjamMR($page_start, $per_page, $showitem, $status, $from_date, $to_date, $keyword, $trans_id, $status_return, $status_notreturn) {

        $filter_condition = "";
        if (isset($trans_id) && !empty($trans_id)) {
            $filter_condition = "AND A.TRANS_PINJAM_MR = '" . $trans_id . "'";
        }
        
        $return_condition ="";
        if ($status_return=="return" && $status_notreturn=="") {
            $return_condition = "AND A.TGL_AKHIR_KEMBALI IS NOT NULL";
        } else if ($status_return=="" && $status_notreturn=="not return") {
            $return_condition = "AND A.TGL_AKHIR_KEMBALI IS NULL";
        } else if ($status_return=="return" && $status_notreturn=="not return") {
            $return_condition = "";
        } else if ($status_return=="" && $status_notreturn=="") {
            $return_condition = "";
        }

        $date_condition = "";
        if(!empty($from_date) && !empty($to_date)) {
            $date_condition = "AND TRUNC(A.TGL_PINJAM) >= TO_DATE('" . $from_date . "','DD.MM.RRRR')
                                AND TRUNC(A.TGL_PINJAM) <= TO_DATE('" . $to_date . "','DD.MM.RRRR')";
        }

        $page_condition = "";
        if (isset($per_page) && !empty($per_page)) {
            $page_condition = "WHERE X.RNUM >= " . ($page_start) . "
                                AND X.RNUM <= " . (($page_start-1) + $per_page) . "";
        }
        $sql = "SELECT
                    X.*
                FROM 
                (
                    SELECT
                        ROW_NUMBER() OVER (ORDER BY A.CREATED_DATE ASC) AS RNUM,
                        A.MR,
                        SUBSTR(A.MR,4) AS MEDREC,
                        B.NAMA AS PASIEN,
                        A.NOKAR_PEMINJAM,
                        C.NAMA_KAR AS PEMINJAM,
                        A.DEPT_PEMINJAM,
                        A.KEPERLUAN,
                        A.CREATED_DATE,
                        A.CREATED_BY,
                        A.DISERAHKAN_OLEH,
                        TO_CHAR(A.TGL_JANJI_KEMBALI, 'DD.MM.RRRR') AS TGL_JANJI_KEMBALI,
                        A.PETUGAS_PENERIMA,
                        NVL(TO_CHAR(A.TGL_AKHIR_KEMBALI, 'DD.MM.RRRR'), '-') AS TGL_AKHIR_KEMBALI,
                        A.CATATAN,
                        A.DIKEMBALIKAN_OLEH,
                        A.TRANS_PINJAM_MR,
                        TO_CHAR(A.TGL_PINJAM, 'DD.MM.RRRR') AS TGL_PINJAM
                    FROM
                        EDP_MANAGER.PINJAM_MR A,
                        HIS_MANAGER.MS_MEDREC B,
                        HIS_MANAGER.MS_KARYAWAN C
                    WHERE
                        A.MR = B.MR
                        AND A.NOKAR_PEMINJAM = 'PLAY_'||C.NO_KAR
                        AND A.SHOW_ITEM LIKE '" . $showitem . "%'
                        " . $return_condition . "
                        " . $date_condition . "
                        " . $filter_condition . "
                        AND (B.NAMA LIKE UPPER('" . $keyword . "'||'%') OR SUBSTR(A.MR, 4) LIKE UPPER('" . $keyword . "'||'%'))
                ) X
                " . $page_condition . "
                ORDER BY X.RNUM ASC";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;

    }

    function getRowCountPinjamMR($showitem, $status, $from_date, $to_date, $status_return, $status_notreturn) {
        
        $return_condition ="";
        if ($status_return=="return" && $status_notreturn=="") {
            $return_condition = "AND A.TGL_AKHIR_KEMBALI IS NOT NULL";
        } else if ($status_return=="" && $status_notreturn=="not return") {
            $return_condition = "AND A.TGL_AKHIR_KEMBALI IS NULL";
        } else if ($status_return=="return" && $status_notreturn=="not return") {
            $return_condition = "";
        } else if ($status_return=="" && $status_notreturn=="") {
            $return_condition = "";
        }

        $date_condition = "";
        if(!empty($from_date) && !empty($to_date)) {
            $date_condition = "AND TRUNC(A.TGL_PINJAM) >= TO_DATE('" . $from_date . "','DD.MM.RRRR')
                                AND TRUNC(A.TGL_PINJAM) <= TO_DATE('" . $to_date . "','DD.MM.RRRR')";
        }
        $sql = "SELECT
                    ROW_NUMBER() OVER (ORDER BY A.TGL_PINJAM ASC) AS RNUM,
                    A.MR,
                    SUBSTR(A.MR,4) AS MEDREC,
                    B.NAMA AS PASIEN,
                    A.NOKAR_PEMINJAM,
                    C.NAMA_KAR AS PEMINJAM,
                    A.DEPT_PEMINJAM,
                    A.CREATED_DATE,
                    A.CREATED_BY,
                    A.DISERAHKAN_OLEH,
                    TO_CHAR(A.TGL_JANJI_KEMBALI,'DD.MM.RRRR') AS TGL_JANJI_KEMBALI,
                    A.PETUGAS_PENERIMA,
                    A.TGL_AKHIR_KEMBALI,
                    A.CATATAN,
                    A.DIKEMBALIKAN_OLEH,
                    A.TRANS_PINJAM_MR,
                    A.TGL_PINJAM
                FROM
                    EDP_MANAGER.PINJAM_MR A,
                    HIS_MANAGER.MS_MEDREC B,
                    HIS_MANAGER.MS_KARYAWAN C
                WHERE
                    A.MR = B.MR
                    AND A.NOKAR_PEMINJAM = 'PLAY_'||C.NO_KAR
                    AND A.SHOW_ITEM LIKE '%' || '" . $showitem . "' || '%'
                    " . $return_condition . "
                    " . $date_condition
                    ;

        $query = $this->oracle_db->query($sql);
        $row_count = $query->num_rows();
        return $row_count;

    }

    function getDataPinjamMR($trans_pinjam_mr) {
        $sql = "SELECT
                    ROW_NUMBER() OVER (ORDER BY A.TGL_PINJAM ASC) AS RNUM,
                    A.MR,
                    SUBSTR(A.MR,4) AS MEDREC,
                    B.NAMA AS PASIEN,
                    NVL(B.TEMPAT_LAHIR,'-') AS TEMPAT_LAHIR, 
                    TO_CHAR(B.TGL_LAHIR,'DD.MM.YYYY') AS TGL_LAHIR,
                    B.NO_HP,
                    NVL(B.ALAMAT,'-') AS ALAMAT, 
                    A.NOKAR_PEMINJAM,
                    SUBSTR(A.NOKAR_PEMINJAM, 6) AS NIK_PEMINJAM,
                    C.NAMA_KAR AS PEMINJAM,
                    A.DEPT_PEMINJAM,
                    A.KEPERLUAN,
                    A.CREATED_DATE,
                    A.CREATED_BY,
                    SUBSTR(A.CREATED_BY, 6) AS NIK_PEMBERI,
                    A.DISERAHKAN_OLEH,
                    TO_CHAR(A.TGL_JANJI_KEMBALI, 'DD.MM.RRRR') AS TGL_JANJI_KEMBALI,
                    A.PETUGAS_PENERIMA,
                    TO_CHAR(A.TGL_AKHIR_KEMBALI, 'DD.MM.RRRR') AS TGL_KEMBALI,
                    A.CATATAN,
                    A.DIKEMBALIKAN_OLEH,
                    A.TRANS_PINJAM_MR,
                    TO_CHAR(A.TGL_PINJAM, 'DD.MM.RRRR') AS TGL_PINJAM
                FROM
                    EDP_MANAGER.PINJAM_MR A,
                    HIS_MANAGER.MS_MEDREC B,
                    HIS_MANAGER.MS_KARYAWAN C
                WHERE
                    A.MR = B.MR
                    AND A.NOKAR_PEMINJAM = 'PLAY_'||C.NO_KAR
                    AND A.SHOW_ITEM = '1'
                    AND A.TRANS_PINJAM_MR = '" . $trans_pinjam_mr . "'";

        $query = $this->oracle_db->query($sql);
        $row = $query->row();
        return $row;

    }
}
