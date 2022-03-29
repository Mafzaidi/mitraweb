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
        $tgl_janji_kembali,
        $catatan,
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
                        CATATAN, 
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
                        TO_DATE('" . $tgl_janji_kembali . "','DD.MM.RRRR'),
                        '" . $catatan . "',
                        '" . $trans_pinjam . "'
                    )
                ";
        $query = $this->oracle_db->query($sql);
    }

    function updatePinjamMR(
        $trans_pinjam,
        $returnBy,
        $receiveBy
    )
    {
        $sql = "UPDATE 
                    EDP_MANAGER.PINJAM_MR A
                SET
                    A.TGL_AKHIR_KEMBALI = SYSDATE,
                    A.DIKEMBALIKAN_OLEH = '" . $returnBy . "',
                    A.PETUGAS_PENERIMA = '" . $receiveBy . "'
                WHERE
                    A.TRANS_PINJAM_MR = '" . $trans_pinjam . "'
                    AND A.TGL_AKHIR_KEMBALI IS NULL
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

    function getRowPinjamMR($page_start, $per_page) {
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
                        A.CREATED_DATE,
                        A.CREATED_BY,
                        A.DISERAHKAN_OLEH,
                        A.TGL_JANJI_KEMBALI,
                        A.PETUGAS_PENERIMA,
                        A.TGL_AKHIR_KEMBALI,
                        A.CATATAN,
                        A.DIKEMBALIKAN_OLEH,
                        A.TRANS_PINJAM_MR
                    FROM
                        EDP_MANAGER.PINJAM_MR A,
                        HIS_MANAGER.MS_MEDREC B,
                        HIS_MANAGER.MS_KARYAWAN C
                    WHERE
                        A.MR = B.MR
                        AND A.NOKAR_PEMINJAM = 'PLAY_'||C.NO_KAR
                        AND A.SHOW_ITEM = '1'
                        AND A.TGL_AKHIR_KEMBALI IS NULL
                ) X
                WHERE X.RNUM >= " . ($page_start) . "
                    AND X.RNUM <= " . (($page_start-1) + $per_page) . "";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;

    }

    function getRowCountPinjamMR() {
        $sql = "SELECT
                    ROW_NUMBER() OVER (ORDER BY A.CREATED_DATE ASC) AS RNUM,
                    A.MR,
                    SUBSTR(A.MR,4) AS MEDREC,
                    B.NAMA AS PASIEN,
                    A.NOKAR_PEMINJAM,
                    C.NAMA_KAR AS PEMINJAM,
                    A.DEPT_PEMINJAM,
                    A.CREATED_DATE,
                    A.CREATED_BY,
                    A.DISERAHKAN_OLEH,
                    A.TGL_JANJI_KEMBALI,
                    A.PETUGAS_PENERIMA,
                    A.TGL_AKHIR_KEMBALI,
                    A.CATATAN,
                    A.DIKEMBALIKAN_OLEH,
                    A.TRANS_PINJAM_MR
                FROM
                    EDP_MANAGER.PINJAM_MR A,
                    HIS_MANAGER.MS_MEDREC B,
                    HIS_MANAGER.MS_KARYAWAN C
                WHERE
                    A.MR = B.MR
                    AND A.NOKAR_PEMINJAM = 'PLAY_'||C.NO_KAR
                    AND A.SHOW_ITEM = '1'
                    AND A.TGL_AKHIR_KEMBALI IS NULL";

        $query = $this->oracle_db->query($sql);
        $row_count = $query->num_rows();
        return $row_count;

    }

    function getDataPinjamMR($trans_pinjam_mr) {
        $sql = "SELECT
                    ROW_NUMBER() OVER (ORDER BY A.CREATED_DATE ASC) AS RNUM,
                    A.MR,
                    SUBSTR(A.MR,4) AS MEDREC,
                    B.NAMA AS PASIEN,
                    NVL(B.TEMPAT_LAHIR,'-') AS TEMPAT_LAHIR, 
                    TO_CHAR(B.TGL_LAHIR,'DD.MM.YYYY') AS TGL_LAHIR,
                    B.NO_HP,
                    NVL(B.ALAMAT,'-') AS ALAMAT, 
                    A.NOKAR_PEMINJAM,
                    C.NAMA_KAR AS PEMINJAM,
                    A.DEPT_PEMINJAM,
                    A.KEPERLUAN,
                    A.CREATED_DATE,
                    A.CREATED_BY,
                    A.DISERAHKAN_OLEH,
                    A.TGL_JANJI_KEMBALI,
                    A.PETUGAS_PENERIMA,
                    A.TGL_AKHIR_KEMBALI,
                    A.CATATAN,
                    A.DIKEMBALIKAN_OLEH,
                    A.TRANS_PINJAM_MR
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
