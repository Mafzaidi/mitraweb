<?php

class M_form_application extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->oracle_db = $this->load->database('oracle', true);
        $this->mysql_db = $this->load->database('default', true);
    }

    // Borrow MR
    function getRowCountPinjamMr($mr) {
        $sql = "SELECT
                    A.*
                FROM
                    EDP_MANAGER.PINJAM_MR A
                WHERE
                    SUBSTR(A.MR,4) = '" . $mr . "'
                    AND A.SHOW_ITEM = '1'
                    AND A.TGL_AKHIR_KEMBALI IS NULL
                ";

        $query = $this->oracle_db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
    }
    // Inpatient File
    function getRowCountCurrentInpatient($keyword, $reg_id) {
        $search_condition = "";
        if (isset($reg_id) && !empty($reg_id)) {
            $search_condition = "AND X.REG_ID = " . ($reg_id) . "";
        }

        $sql = "SELECT
                    X.*,
                    NVL(Y.REG_ID,'') AS REG_BERKAS
                FROM 
                    (
                    SELECT
                        ROW_NUMBER() OVER (ORDER BY A.TGL_MASUK ASC) AS RNUM,
                        SUBSTR(A.MR, 4) AS MEDREC,
                        SUBSTR(D.NAMA, 0, LENGTH(D.NAMA) -3) AS PASIEN,
                        A.RUANG_ID,
                        C.NAMA_DEPT,
                        E.NAMA_DR,
                        TO_CHAR(A.TGL_MASUK, 'DD.MM.RRRR') AS TGL_MASUK,
                        F.REKANAN_NAMA,
                        A.REG_ID
                    FROM 
                        HIS_MANAGER.MS_REG A, 
                        HIS_MANAGER.MS_RUANG B,
                        HIS_MANAGER.MS_HIS_DEPT C,
                        HIS_MANAGER.MS_MEDREC D,
                        HIS_MANAGER.MS_HIS_DOKTER E,
                        HIS_MANAGER.MS_REKANAN F
                    WHERE 
                        A.MR = B.MR 
                        AND A.REG_ID = B.REG_ID 
                        AND A.RUANG_ID = B.RUANG_ID
                        AND B.DEPT_ID = C.DEPT_ID
                        AND A.MR = D.MR
                        AND A.DOKTER_ID = E.DOKTER_ID
                        AND A.REKANAN_ID = F.REKANAN_ID
                        AND A.TGL_KELUAR IS NULL 
                        AND A.DONE_STATUS <> '03' 
                        AND (D.NAMA LIKE UPPER('" . $keyword . "'||'%') OR SUBSTR(A.MR, 4) LIKE UPPER('" . $keyword . "'||'%'))
                    ) X, 
                    EDP_MANAGER.MS_REG_BERKAS Y
                WHERE
                    X.REG_ID = Y.REG_ID (+)
                    " . $search_condition . "
            ";

        $query = $this->oracle_db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    function getRowCurrentInpatient($page_start, $per_page, $keyword, $reg_id) {
        
        $page_condition = "";
        if (isset($per_page) && !empty($per_page)) {
            $page_condition = "AND X.RNUM >= " . ($page_start) . "
                                AND X.RNUM <= " . (($page_start-1) + $per_page) . "";
        }

        $search_condition = "";
        if (isset($reg_id) && !empty($reg_id)) {
            $search_condition = "AND A.REG_ID = '" . ($reg_id) . "'";
        }
        
        $sql = "SELECT
                    X.RNUM, 
                    X.MEDREC, 
                    X.PASIEN, 
                    X.RUANG_ID,
                    X.NAMA_DEPT, 
                    X.NAMA_DR, 
                    X.TGL_MASUK, 
                    X.REKANAN_NAMA, 
                    X.REG_ID,
                    NVL(Y.TRANS_ID, 'N') AS REG_BERKAS, 
                    NVL(LISTAGG(Z.BERKAS_ID, ',') WITHIN GROUP (ORDER BY Y.TRANS_ID), 'N') AS LIST_REG,
                    (
                        SELECT
                            NVL(LISTAGG(X1.BERKAS_ID, ',') WITHIN GROUP (ORDER BY X1.PRIORITY), 'N') 
                        FROM
                            EDP_MANAGER.MS_BERKAS X1
                        WHERE 
                            X1.PRIORITY = 'H'
                        GROUP BY X1.PRIORITY
                    ) AS HIGH_PRIORITY,
                    (
                        SELECT
                            NVL(LISTAGG(X1.BERKAS_ID, ',') WITHIN GROUP (ORDER BY X1.PRIORITY), 'N') 
                        FROM
                            EDP_MANAGER.MS_BERKAS X1
                        WHERE 
                            X1.PRIORITY = 'M'
                        GROUP BY X1.PRIORITY
                    ) AS MEDIUM_PRIORITY,
                    (
                        SELECT
                            NVL(LISTAGG(X1.BERKAS_ID, ',') WITHIN GROUP (ORDER BY X1.PRIORITY), 'N') 
                        FROM
                            EDP_MANAGER.MS_BERKAS X1
                        WHERE 
                            X1.PRIORITY = 'L'
                        GROUP BY X1.PRIORITY
                    ) AS LOW_PRIORITY,
                    NVL(CASE WHEN V.REKANAN_ID = X.REKANAN_ID THEN V.LIST_TEMPL END, 'N') AS LIST_REK_TEMPL,
                    (
                        SELECT
                            NVL(LISTAGG(X1.BERKAS_ID, ',') WITHIN GROUP (ORDER BY X1.REKANAN_ID), 'N') 
                        FROM
                            EDP_MANAGER.DT_BERKAS_TEMPLATE X1
                        WHERE 
                            X1.REKANAN_ID = 'DEFAULT'
                        GROUP BY X1.REKANAN_ID
                    ) AS LIST_DEF_TEMPL
                FROM 
                    (
                        SELECT
                            ROW_NUMBER() OVER (ORDER BY A.TGL_MASUK ASC) AS RNUM,
                            SUBSTR(A.MR, 4) AS MEDREC,
                            SUBSTR(D.NAMA, 0, LENGTH(D.NAMA) -3) AS PASIEN,
                            A.RUANG_ID,
                            C.NAMA_DEPT,
                            E.NAMA_DR,
                            TO_CHAR(A.TGL_MASUK, 'DD.MM.RRRR') AS TGL_MASUK,
                            A.REKANAN_ID,
                            F.REKANAN_NAMA,
                            A.REG_ID
                        FROM 
                            HIS_MANAGER.MS_REG A, 
                            HIS_MANAGER.MS_RUANG B,
                            HIS_MANAGER.MS_HIS_DEPT C,
                            HIS_MANAGER.MS_MEDREC D,
                            HIS_MANAGER.MS_HIS_DOKTER E,
                            HIS_MANAGER.MS_REKANAN F
                        WHERE 
                            A.MR = B.MR 
                            AND A.REG_ID = B.REG_ID 
                            AND A.RUANG_ID = B.RUANG_ID
                            AND B.DEPT_ID = C.DEPT_ID
                            AND A.MR = D.MR
                            AND A.DOKTER_ID = E.DOKTER_ID
                            AND A.REKANAN_ID = F.REKANAN_ID
                            AND A.TGL_KELUAR IS NULL 
                            AND A.DONE_STATUS <> '03'
                            AND (D.NAMA LIKE UPPER('" . $keyword . "'||'%') OR SUBSTR(A.MR, 4) LIKE UPPER('" . $keyword . "'||'%'))
                            " . $search_condition . "
                        GROUP BY 
                            SUBSTR(A.MR, 4),
                            A.TGL_MASUK,
                            D.NAMA,
                            A.RUANG_ID,
                            C.NAMA_DEPT,
                            E.NAMA_DR,
                            TO_CHAR(A.TGL_MASUK, 'DD.MM.RRRR'),
                            A.REKANAN_ID,
                            F.REKANAN_NAMA,
                            A.REG_ID
                    ) X, 
                    EDP_MANAGER.MS_REG_BERKAS Y,
                    EDP_MANAGER.DT_REG_BERKAS Z,
                    (
                        SELECT
                            X1.REKANAN_ID, LISTAGG(X1.BERKAS_ID, ',') WITHIN GROUP (ORDER BY X1.REKANAN_ID) AS LIST_TEMPL
                        FROM
                            EDP_MANAGER.DT_BERKAS_TEMPLATE X1
                        GROUP BY X1.REKANAN_ID
                    ) V
                WHERE
                    X.REG_ID = Y.REG_ID (+)
                    AND Y.TRANS_ID = Z.TRANS_ID (+)
                    AND X.REKANAN_ID = V.REKANAN_ID (+)
                    " . $page_condition . "
                GROUP BY 
                    X.RNUM, 
                    X.MEDREC, 
                    X.PASIEN, 
                    X.RUANG_ID,
                    X.NAMA_DEPT, 
                    X.NAMA_DR, 
                    X.TGL_MASUK, 
                    X.REKANAN_NAMA, 
                    X.REG_ID, 
                    Y.TRANS_ID,
                    X.REKANAN_ID,
                    V.REKANAN_ID,
                    V.LIST_TEMPL
                ORDER BY X.RNUM ASC
            ";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }

    function getDataCurrentInpatient($reg_id) {
        $sql = "SELECT
                    X.*,
                    NVL(Y.REG_ID,'') AS REG_BERKAS
                FROM 
                    (
                    SELECT
                        ROW_NUMBER() OVER (ORDER BY A.TGL_MASUK ASC) AS RNUM,
                        SUBSTR(A.MR, 4) AS MEDREC,
                        A.MR,
                        SUBSTR(D.NAMA, 0, LENGTH(D.NAMA) -3) AS PASIEN,
                        TO_CHAR(D.TGL_LAHIR,'DD.MM.RRRR') AS TGL_LAHIR,
                        ROUND((TRUNC (SYSDATE - D.TGL_LAHIR) / 365), 0)||' Thn ' ||  ROUND((TRUNC ((SYSDATE - D.TGL_LAHIR) / 365)/12), 0)|| ' Bln' UMUR,
                        A.RUANG_ID,
                        C.NAMA_DEPT,
                        E.NAMA_DR,
                        TO_CHAR(A.TGL_MASUK, 'DD.MM.RRRR') AS TGL_MASUK,
                        F.REKANAN_ID, 
                        F.REKANAN_NAMA,
                        A.REG_ID
                    FROM 
                        HIS_MANAGER.MS_REG A, 
                        HIS_MANAGER.MS_RUANG B,
                        HIS_MANAGER.MS_HIS_DEPT C,
                        HIS_MANAGER.MS_MEDREC D,
                        HIS_MANAGER.MS_HIS_DOKTER E,
                        HIS_MANAGER.MS_REKANAN F
                    WHERE 
                        A.MR = B.MR 
                        AND A.REG_ID = B.REG_ID 
                        AND A.RUANG_ID = B.RUANG_ID
                        AND B.DEPT_ID = C.DEPT_ID
                        AND A.MR = D.MR
                        AND A.DOKTER_ID = E.DOKTER_ID
                        AND A.REKANAN_ID = F.REKANAN_ID
                        AND A.TGL_KELUAR IS NULL 
                        AND A.DONE_STATUS <> '03' 
                    ) X, 
                    EDP_MANAGER.MS_REG_BERKAS Y
                WHERE
                    X.REG_ID = Y.REG_ID (+)
                    AND X.REG_ID = '" . $reg_id . "'
                ORDER BY X.RNUM ASC
            ";

            $query = $this->oracle_db->query($sql);
            $row = $query->row();
            return $row;
    }

    function getBerkas() {
        $sql = "SELECT
                    A.BERKAS_ID, A.KETERANGAN
                FROM
                    EDP_MANAGER.MS_BERKAS A
                WHERE
                    A.SHOW_ITEM = '1'
        ";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }

    function getListRegBerkas($reg_id) {
        $sql = "SELECT
                    A.BERKAS_ID, 
                    A.KETERANGAN,
                    A.TEMPLATE,
                    CASE WHEN A.TEMPLATE = 'Y'
                        THEN
                            CASE WHEN 
                                (
                                SELECT COUNT(*) FROM EDP_MANAGER.DT_BERKAS_TEMPLATE A1 
                                WHERE A1.BERKAS_ID = A.BERKAS_ID AND A1.REKANAN_ID = (
                                    SELECT B1.REKANAN_ID FROM MS_REG B1 
                                    WHERE B1.REG_ID = '" . $reg_id . "'
                                    AND A1.SHOW_ITEM = '1'
                                    )
                                ) > 0 THEN 'Y' 
                            ELSE 
                                CASE WHEN (
                                SELECT COUNT(*) FROM EDP_MANAGER.DT_BERKAS_TEMPLATE A1 
                                WHERE A1.BERKAS_ID = A.BERKAS_ID AND A1.REKANAN_ID = 'DEFAULT'
                                AND A1.SHOW_ITEM = '1'
                                ) > 0 THEN 'Y' ELSE 'N' END
                            END
                    ELSE 'N' END AS UPLOADED,                     
                    CASE WHEN A.TEMPLATE = 'Y'
                        THEN
                            CASE WHEN 
                                (
                                SELECT COUNT(*) FROM EDP_MANAGER.DT_BERKAS_TEMPLATE A1 
                                WHERE A1.BERKAS_ID = A.BERKAS_ID AND A1.REKANAN_ID = 'DEFAULT'
                                AND A1.SHOW_ITEM = '1'
                                ) > 0 THEN 'Y' 
                            ELSE 'N'
                            END
                    ELSE 'N' END AS UPLOADED_DEFAULT,
                    CASE WHEN A.TEMPLATE = 'Y'
                        THEN
                            CASE WHEN 
                                (
                                SELECT COUNT(*) FROM EDP_MANAGER.DT_BERKAS_TEMPLATE A1 
                                WHERE A1.BERKAS_ID = A.BERKAS_ID AND A1.REKANAN_ID = (
                                    SELECT B1.REKANAN_ID FROM MS_REG B1 
                                    WHERE B1.REG_ID = '" . $reg_id . "'
                                    )
                                    AND A1.SHOW_ITEM = '1'
                                ) > 0 THEN 'Y'
                            ELSE 'N' 
                            END
                    ELSE 'N' END AS UPLOADED_REKANAN,
                    NVL((
                        SELECT
                            NVL(LISTAGG(A1.REKANAN_ID, ',') WITHIN GROUP (ORDER BY A1.BERKAS_ID), 'N') 
                        FROM
                            EDP_MANAGER.DT_BERKAS_TEMPLATE A1
                        WHERE 
                            A1.BERKAS_ID = A.BERKAS_ID
                            AND (A1.REKANAN_ID = 'DEFAULT' OR A1.REKANAN_ID = (
                                SELECT C1.REKANAN_ID FROM MS_REG C1 WHERE C1.REG_ID = '" . $reg_id . "'
                            ))
                        GROUP BY A1.BERKAS_ID
                    ),'N') AS LIST_REKID_TMPL,
                    NVL((
                        SELECT
                            NVL(LISTAGG(B1.REKANAN_NAMA, ',') WITHIN GROUP (ORDER BY A1.BERKAS_ID), 'N') 
                        FROM
                            EDP_MANAGER.DT_BERKAS_TEMPLATE A1,
                            HIS_MANAGER.MS_REKANAN B1
                        WHERE 
                            A1.BERKAS_ID = A.BERKAS_ID
                            AND A1.REKANAN_ID = B1.REKANAN_ID
                            AND (A1.REKANAN_ID = 'DEFAULT' OR A1.REKANAN_ID = (
                                SELECT C1.REKANAN_ID FROM MS_REG C1 WHERE C1.REG_ID = '" . $reg_id . "'
                            ))
                        GROUP BY A1.BERKAS_ID
                    ),'N') AS LIST_REKNAME_TMPL,
                    CASE WHEN (
                        SELECT COUNT(*) FROM EDP_MANAGER.DT_REG_BERKAS A1, 
                        EDP_MANAGER.MS_REG_BERKAS B1 WHERE A1.BERKAS_ID = A.BERKAS_ID AND A1.TRANS_ID = B1.TRANS_ID AND B1.REG_ID = '" . $reg_id . "'
                        AND B1.SHOW_ITEM = '1'
                    ) > 0 THEN 'Y' ELSE 'N' END AS REGISTERED,
                    NVL((
                        SELECT
                            NVL(LISTAGG(B1.BERKAS_ID, ',') WITHIN GROUP (ORDER BY A1.REG_ID), 'N') 
                        FROM
                            EDP_MANAGER.MS_REG_BERKAS A1,
                            EDP_MANAGER.DT_REG_BERKAS B1
                        WHERE
                            A1.TRANS_ID = B1.TRANS_ID 
                            AND A1.SHOW_ITEM = '1'
                            AND B1.SHOW_ITEM = '1'
                            AND A1.REG_ID = '" . $reg_id . "'
                        GROUP BY A1.REG_ID
                    ),'N') AS LIST_BERKAS_REG
                FROM
                    EDP_MANAGER.MS_BERKAS A
                WHERE
                    A.SHOW_ITEM = '1'
                ORDER BY A.BERKAS_ID";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }

    function getTemplateBerkas($reg_id, $berkas_id) {
        $sql = "SELECT
                    A.*, B.REKANAN_NAMA
                FROM
                    EDP_MANAGER.DT_BERKAS_TEMPLATE A,
                    HIS_MANAGER.MS_REKANAN B
                WHERE
                    (A.REKANAN_ID = 'DEFAULT' OR A.REKANAN_ID = (
                        SELECT REKANAN_ID FROM MS_REG WHERE REG_ID = '" . $reg_id . "'
                    ))
                    AND A.BERKAS_ID = '" . $berkas_id . "'
                    AND A.REKANAN_ID = B.REKANAN_ID
                    AND A.SHOW_ITEM = '1'";

        $query = $this->oracle_db->query($sql);
        $result = $query->result();
        return $result;
    }

    function getTransRegBerkas()
    {
        $sql = "SELECT  
                    'RB' || SUBSTR(TO_CHAR(EDP_MANAGER.SEQ_REG_BERKAS.nextval, '000000'),2) AS TRANS_ID
                FROM 
                    DUAL";

        $query = $this->oracle_db->query($sql);
        $row = $query->row();
        return $row;
    }

    function saveMsRegBerkas(
        $trans_id,
        $reg_id,
        $mr,
        $created_date,
        $created_by,
        $status,
        $show_item
    )
    {
        $sql = "INSERT INTO  EDP_MANAGER.MS_REG_BERKAS
                    (
                        TRANS_ID, 
                        REG_ID, 
                        MR, 
                        CREATED_DATE, 
                        CREATED_BY, 
                        STATUS, 
                        SHOW_ITEM
                    )
                VALUES
                    (
                        '" . $trans_id . "',
                        '" . $reg_id . "',
                        '" . $mr . "',
                        " . $created_date . ",
                        '" . $created_by . "',
                        '" . $status . "',
                        '" . $show_item . "'
                    )
                ";
        $query = $this->oracle_db->query($sql);
    }

    function saveDtRegBerkas(
        $trans_id,
        $berkas_id,
        $queue_item,
        $file_path,
        $file_name,
        $url,
        $created_date,
        $created_by,
        $show_item,
        $status
    )
    {
        $sql = "INSERT INTO  EDP_MANAGER.DT_REG_BERKAS
                    (
                        TRANS_ID, 
                        BERKAS_ID, 
                        QUEUE_ITEM,
                        FILE_PATH,
                        FILE_NAME,
                        URL,
                        CREATED_DATE, 
                        CREATED_BY, 
                        SHOW_ITEM,
                        STATUS
                    )
                VALUES
                    (
                        '" . $trans_id . "',
                        '" . $berkas_id . "',
                        " . $queue_item . ",
                        '" . $file_path . "',
                        '" . $file_name . "',
                        '" . $url . "',
                        " . $created_date . ",
                        '" . $created_by . "',
                        '" . $show_item . "',
                        '" . $status . "'
                    )
                ";
        $query = $this->oracle_db->query($sql);
    }

    function saveDtBerkasTemplate(
        $berkas_id,
        $rekanan_id,
        $tittle,
        $file_path,
        $file_name,
        $url,
        $created_date,
        $created_by,
        $show_item
    )
    {
        $sql = "INSERT INTO  EDP_MANAGER.DT_BERKAS_TEMPLATE
                    ( 
                        BERKAS_ID, 
                        REKANAN_ID,
                        TITTLE,
                        FILE_PATH,
                        FILE_NAME,
                        CREATED_DATE,
                        CREATED_BY,
                        URL,
                        SHOW_ITEM
                    )
                VALUES
                    (
                        '" . $berkas_id . "',
                        '" . $rekanan_id . "',
                        '" . $tittle . "',
                        '" . $file_path . "',
                        '" . $file_name . "',
                        SYSDATE,
                        '" . $created_by . "',
                        '" . $url . "',
                        '" . $show_item . "'
                    )
                ";
        $query = $this->oracle_db->query($sql);
    }
}