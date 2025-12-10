CREATE DATABASE QLSV;
GO
USE QLSV;
GO

CREATE TABLE KHOA (
    Makh   NVARCHAR(10) PRIMARY KEY,
    Vpkh   NVARCHAR(100)
);
GO

CREATE TABLE LOP (
    Malop  NVARCHAR(10) PRIMARY KEY,
    Makh   NVARCHAR(10),
    FOREIGN KEY (Makh) REFERENCES KHOA(Makh)
        ON UPDATE CASCADE ON DELETE NO ACTION
);
GO

CREATE TABLE SINHVIEN (
    Masv   NVARCHAR(10) PRIMARY KEY,
    Hosv   NVARCHAR(50),
    Tensv  NVARCHAR(30),
    Nssv   DATE,
    Dcsv   NVARCHAR(200),
    Loptr  BIT,
    Malop  NVARCHAR(10),
    FOREIGN KEY (Malop) REFERENCES LOP(Malop)
        ON UPDATE CASCADE ON DELETE NO ACTION
);
GO

CREATE TABLE MONHOC (
    Mamh   NVARCHAR(10) PRIMARY KEY,
    Tenmh  NVARCHAR(100),
    LT     INT,
    TH     INT
);
GO

CREATE TABLE CTHOC (
    Malop  NVARCHAR(10),
    HK     INT,
    Mamh   NVARCHAR(10),
    PRIMARY KEY (Malop, HK, Mamh),
    FOREIGN KEY (Malop) REFERENCES LOP(Malop)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (Mamh) REFERENCES MONHOC(Mamh)
        ON UPDATE CASCADE ON DELETE NO ACTION
);
GO

CREATE TABLE DIEMSV (
    Masv   NVARCHAR(10),
    Mamh   NVARCHAR(10),
    Lan    INT,
    Diem   FLOAT,
    PRIMARY KEY (Masv, Mamh, Lan),
    FOREIGN KEY (Masv) REFERENCES SINHVIEN(Masv)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (Mamh) REFERENCES MONHOC(Mamh)
        ON UPDATE CASCADE ON DELETE NO ACTION
);
GO


-- INSERT DATA
INSERT INTO KHOA VALUES
(N'CNTT', N'Tòa A1'),
(N'KT',   N'Tòa B2');

INSERT INTO LOP VALUES
(N'TH1', N'CNTT'),
(N'TH2', N'CNTT'),
(N'KT1', N'KT');

INSERT INTO SINHVIEN VALUES
(N'SV01', N'Nguyen Van', N'An', '2004-01-01', N'HCM', 1, N'TH1'),
(N'SV02', N'Tran Thi',   N'Binh', '2004-02-11', N'HCM', 0, N'TH1'),
(N'SV03', N'Le Van',     N'Cuong', '2004-03-22', N'DN',  0, N'TH2'),
(N'SV04', N'Pham Thi',   N'Dung', '2004-04-15', N'HN',  0, N'TH2'),
(N'SV05', N'Hoang Van',  N'Em', '2003-05-12', N'HN', 0,  N'KT1');

INSERT INTO MONHOC VALUES
(N'CSDL', N'Co So Du Lieu', 30, 15),
(N'CTDL', N'Cau Truc DL',   45, 20),
(N'MOB',  N'Lap Trinh Mobile', 30, 30),
(N'WEB',  N'Lap Trinh Web', 45, 30);

INSERT INTO CTHOC VALUES
(N'TH1', 1, N'CSDL'),
(N'TH1', 1, N'CTDL'),
(N'TH1', 2, N'MOB'),
(N'TH1', 2, N'WEB'),

(N'TH2', 1, N'CSDL'),
(N'TH2', 2, N'CTDL');

INSERT INTO DIEMSV VALUES
(N'SV01', N'CSDL', 1, 8.0),
(N'SV01', N'CTDL', 1, 7.0),
(N'SV01', N'MOB',  1, 6.0),

(N'SV02', N'CSDL', 1, 4.0),
(N'SV02', N'CTDL', 1, 5.0),

(N'SV03', N'CSDL', 1, 9.0),
(N'SV03', N'CTDL', 1, 8.0),

(N'SV04', N'CSDL', 1, 2.0),
(N'SV04', N'CTDL', 1, 3.0),

(N'SV05', N'CSDL', 1, 6.5);
GO



-- 1. Danh sách lớp
SELECT * FROM LOP;

-- 2. Ds sv lớp TH1
SELECT * FROM SINHVIEN WHERE Malop = 'TH1';

-- 3. Ds sv khoa CNTT
SELECT * FROM SINHVIEN JOIN LOP ON SINHVIEN.Malop = LOP.Malop WHERE LOP.Makh = 'CNTT';

-- 4. Chương trình hoc lớp TH1
SELECT CTHOC.HK, CTHOC.Mamh, MONHOC.Tenmh, MONHOC.LT, MONHOC.TH FROM CTHOC JOIN MONHOC ON CTHOC.Mamh = MONHOC.Mamh WHERE CTHOC.Malop = 'TH1' ORDER BY CTHOC.HK, CTHOC.Mamh;

-- 5. Điểm lần 1 môn CSDL của sv lớp TH1
SELECT SINHVIEN.Masv, SINHVIEN.Hosv, SINHVIEN.Tensv, DIEMSV.Diem FROM SINHVIEN
JOIN DIEMSV ON SINHVIEN.Masv = DIEMSV.Masv WHERE SINHVIEN.Malop = 'TH1' AND DIEMSV.Mamh = 'CSDL' AND DIEMSV.Lan = 1;

-- 6. Điểm trung bình lần 1 môn CTDL của lớp TH1.
SELECT AVG(d.Diem) AS DiemTB FROM SINHVIEN sv
JOIN DIEMSV d ON sv.Masv = d.Masv
WHERE sv.Malop = 'TH1' AND d.Mamh = 'CTDL' AND d.Lan = 1;

-- 7. Số lượng SV của lớp TH2.
SELECT COUNT(*) AS SoLuongSV FROM SINHVIEN
WHERE Malop = 'TH2';

-- 8. Lớp TH1 phải học bao nhiêu môn trong HK1 và HK2.
SELECT HK, COUNT(Mamh) AS SoMon FROM CTHOC
WHERE Malop = 'TH1' AND HK IN (1, 2) 
GROUP BY HK;

-- 9. Cho biết 3 SV đầu tiên có điểm thi lần 1 cao nhất môn CSDL.
SELECT sv.Masv, sv.Hosv, sv.Tensv, d.Diem FROM SINHVIEN sv
JOIN DIEMSV d ON sv.Masv = d.Masv
WHERE d.Mamh = 'CSDL'
  AND d.Lan = 1
ORDER BY d.Diem DESC
LIMIT 3;

-- 10. Cho biết sĩ số từng lớp.
SELECT Malop, COUNT(*) AS SiSo
FROM SINHVIEN
GROUP BY Malop;

-- 11. Khoa nào đông SV nhất.
SELECT k.Makh, COUNT(sv.Masv) AS SoSV
FROM KHOA k
JOIN LOP l ON k.Makh = l.Makh
JOIN SINHVIEN sv ON l.Malop = sv.Malop
GROUP BY k.Makh
ORDER BY SoSV DESC
LIMIT 1;

-- 12. Lớp nào đông nhất khoa CNTT.
SELECT l.Malop, COUNT(sv.Masv) AS SoSV
FROM LOP l
JOIN SINHVIEN sv ON l.Malop = sv.Malop
WHERE l.Makh = 'CNTT'
GROUP BY l.Malop
ORDER BY SoSV DESC
LIMIT 1;

-- 13. Môn học nào mà ở lần thi 1 có số SV không đạt nhiều nhất.
SELECT Mamh, COUNT(*) AS SoKhongDat
FROM DIEMSV
WHERE Lan = 1 AND Diem < 5
GROUP BY Mamh
ORDER BY SoKhongDat DESC
LIMIT 1;

-- 14. Tìm điểm thi lớn nhất của mỗi SV cho mỗi môn học (vì SV được thi nhiều lần).
SELECT Masv, Mamh, MAX(Diem) AS DiemCaoNhat
FROM DIEMSV
GROUP BY Masv, Mamh;

-- 15. Điểm trung bình của từng lớp khoa CNTT ở lần thi thứ nhất môn CSDL.
SELECT l.Malop, AVG(d.Diem) AS DiemTB
FROM KHOA k
JOIN LOP l ON k.Makh = l.Makh
JOIN SINHVIEN sv ON l.Malop = sv.Malop
JOIN DIEMSV d ON sv.Masv = d.Masv
WHERE k.Makh = 'CNTT'
  AND d.Mamh = 'CSDL'
  AND d.Lan = 1
GROUP BY l.Malop;

-- 16. Sinh viên nào của lớp TH1 đã thi đạt tất cả các môn học ở lần 1 của HK2.
SELECT sv.Masv, sv.Hosv, sv.Tensv
FROM SINHVIEN sv
JOIN CTHOC c ON sv.Malop = c.Malop
JOIN DIEMSV d ON sv.Masv = d.Masv AND c.Mamh = d.Mamh
WHERE sv.Malop = 'TH1'
  AND c.HK = 2
  AND d.Lan = 1
GROUP BY sv.Masv
HAVING MIN(d.Diem) >= 5;

-- 17. Danh sách SV nhận học bổng học kỳ 2 của lớp TH2, nghĩa là đạt tất cả các môn học của học kỳ này ở lần thi thứ nhất.
SELECT sv.Masv, sv.Hosv, sv.Tensv
FROM SINHVIEN sv
JOIN CTHOC c ON sv.Malop = c.Malop
JOIN DIEMSV d ON sv.Masv = d.Masv AND c.Mamh = d.Mamh
WHERE sv.Malop = 'TH2'
  AND c.HK = 2
  AND d.Lan = 1
GROUP BY sv.Masv
HAVING MIN(d.Diem) >= 5;

-- 18. Biết rằng lớp TH1 đã học đủ 6 học kỳ, cho biết SV nào đủ điều kiện thi tốt nghiệp, nghĩa là đã đạt đủ tất cả các môn
SELECT sv.Masv, sv.Hosv, sv.Tensv
FROM SINHVIEN sv
JOIN CTHOC c ON sv.Malop = c.Malop
JOIN DIEMSV d ON sv.Masv = d.Masv AND c.Mamh = d.Mamh
WHERE sv.Malop = 'TH1'
  AND c.HK BETWEEN 1 AND 6
  AND d.Lan = 1
GROUP BY sv.Masv
HAVING MIN(d.Diem) >= 5;




--USE QLSV;
--GO

--IF OBJECT_ID('DIEMSV', 'U') IS NOT NULL DROP TABLE DIEMSV;
--IF OBJECT_ID('CTHOC', 'U') IS NOT NULL DROP TABLE CTHOC;
--IF OBJECT_ID('MONHOC', 'U') IS NOT NULL DROP TABLE MONHOC;
--IF OBJECT_ID('SINHVIEN', 'U') IS NOT NULL DROP TABLE SINHVIEN;
--IF OBJECT_ID('LOP', 'U') IS NOT NULL DROP TABLE LOP;
--IF OBJECT_ID('KHOA', 'U') IS NOT NULL DROP TABLE KHOA;
--GO


-- Thêm dữ liệu
INSERT INTO KHOA VALUES
(N'QTKD', N'Tòa C1'),
(N'NN',   N'Tòa C2');

INSERT INTO LOP VALUES
(N'Q1', N'QTKD'),
(N'Q2', N'QTKD'),
(N'NN1', N'NN'),
(N'NN2', N'NN');

INSERT INTO SINHVIEN VALUES
(N'SV06', N'Pham Van', N'Khoi', '2004-09-10', N'HCM', 0, N'TH1', N'Nam'),
(N'SV07', N'Nguyen Thi', N'Loan', '2003-12-21', N'DN', 0, N'TH2', N'Nữ'),
(N'SV08', N'Bui Van', N'Tuan', '2004-08-01', N'HN', 1, N'KT1', N'Nam'),

(N'SV09', N'Tran Quoc', N'Bao', '2003-04-12', N'HCM', 0, N'Q1', N'Nam'),
(N'SV10', N'Hoang Thi', N'Nhu', '2004-06-02', N'HCM', 1, N'Q1', N'Nữ'),
(N'SV11', N'Le Van', N'Thien', '2004-01-19', N'DN', 0, N'Q2', N'Nam'),
(N'SV12', N'Pham Thi', N'Hong', '2003-11-15', N'HN', 0, N'Q2', N'Nữ'),

(N'SV13', N'Vu Minh', N'Trung', '2004-07-22', N'DN', 0, N'NN1', N'Nam'),
(N'SV14', N'Nguyen Thi', N'Thuy', '2003-03-09', N'HN', 1, N'NN1', N'Nữ'),
(N'SV15', N'Do Van', N'Loc', '2004-09-30', N'HCM', 0, N'NN2', N'Nam'),
(N'SV16', N'Pham Thi', N'Yen', '2004-10-05', N'DN', 0, N'NN2', N'Nữ');

INSERT INTO MONHOC VALUES
(N'MKT',  N'Marketing Co Ban', 30, 15),
(N'KTDN', N'Kinh Te Doanh Nghiep', 45, 30),
(N'TA',   N'Tieng Anh Chuyen Nganh', 60, 30);

-- Q1 học kỳ 1–2
INSERT INTO CTHOC VALUES
(N'Q1', 1, N'MKT'),
(N'Q1', 1, N'KTDN'),
(N'Q1', 2, N'TA');

-- Q2 học kỳ 1–2
INSERT INTO CTHOC VALUES
(N'Q2', 1, N'MKT'),
(N'Q2', 2, N'KTDN'),
(N'Q2', 2, N'TA');

-- NN1 học kỳ 1–2
INSERT INTO CTHOC VALUES
(N'NN1', 1, N'TA'),
(N'NN1', 2, N'MKT');

-- NN2 học kỳ 1–2
INSERT INTO CTHOC VALUES
(N'NN2', 1, N'TA'),
(N'NN2', 2, N'KTDN');

INSERT INTO DIEMSV VALUES
-- SV06 – TH1
(N'SV06', N'CSDL', 1, 7.0),
(N'SV06', N'CTDL', 1, 6.5),
(N'SV06', N'MOB',  1, 8.0),

-- SV07 – TH2
(N'SV07', N'CSDL', 1, 8.5),
(N'SV07', N'CTDL', 1, 7.5),

-- SV08 – KT1
(N'SV08', N'CSDL', 1, 5.5),

-- SV09 – Q1
(N'SV09', N'MKT',  1, 7.5),
(N'SV09', N'KTDN', 1, 6.0),

-- SV10 – Q1
(N'SV10', N'MKT',  1, 9.0),
(N'SV10', N'KTDN', 1, 8.0),
(N'SV10', N'TA',   1, 7.0),

-- SV11 – Q2
(N'SV11', N'MKT',  1, 6.5),
(N'SV11', N'KTDN', 1, 5.5),

-- SV12 – Q2
(N'SV12', N'MKT',  1, 7.0),
(N'SV12', N'KTDN', 1, 9.0),
(N'SV12', N'TA',   1, 8.5),

-- SV13 – NN1
(N'SV13', N'TA',   1, 8.0),
(N'SV13', N'MKT',  1, 7.0),

-- SV14 – NN1
(N'SV14', N'TA',   1, 6.0),

-- SV15 – NN2
(N'SV15', N'TA',   1, 7.5),
(N'SV15', N'KTDN', 1, 6.0),

-- SV16 – NN2
(N'SV16', N'TA',   1, 5.0),
(N'SV16', N'KTDN', 1, 7.0);
