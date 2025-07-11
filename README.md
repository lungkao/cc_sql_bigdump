# BigDump Modern SQL Importer

A modern SQL file importer built with PHP and JavaScript featuring a beautiful UI and easy-to-use interface.
If you find BigDump Modern SQL Importer
 helpful, you can support the developer by buying a coffee:

👉&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://buymeacoffee.com/cheuachatchai" >![buy_me_a_coffee](https://github.com/conseilgouz/plg_system_cgwebp_j4/assets/19435246/4fda4cb5-64f1-4717-81ae-c71a0fc26c2d)</a>
## ✨ Features

- **Drag & Drop**: Simply drag and drop SQL files
- **Dark Mode**: Dark theme for comfortable night-time usage
- **Progress Tracking**: Real-time progress monitoring during import
- **Batch Processing**: Process files in chunks to prevent memory overflow
- **Error Handling**: Comprehensive error management and reporting
- **Responsive Design**: Mobile and tablet friendly interface
- **File Management**: Upload, delete, and import file operations

## 🚀 Installation

1. **Copy the file** `cc-sql-bigdump.php` to your web server
2. **Configure settings** in the CONFIG section of the file:

```php
$db_host = 'localhost';        // Database host
$db_user = 'your_username';    // Database username
$db_pass = 'your_password';    // Database password
$db_name = 'your_database';    // Database name
$upload_dir = __DIR__;         // Upload directory
$lines_per_session = 1000;     // Lines per processing session
$max_file_size = 1024*1024*128; // Maximum file size (128MB)
```

3. **Access the file** via web browser: `http://your-domain.com/cc-sql-bigdump.php`

## 📋 System Requirements

- **PHP 7.0+** with MySQLi extension
- **MySQL/MariaDB** database
- **Web server** (Apache, Nginx, or PHP Built-in server)
- **Write permissions** in the specified directory

## 🎯 How to Use

### Uploading Files
1. **Drag and drop** `.sql` files into the Drop Zone area
2. Or **click "Choose File"** button to select files from your computer
3. The system will upload files and display them in the list

### Importing Data
1. **Click "Import"** button on the desired file
2. The system will process data in chunks (1000 lines per session)
3. **Monitor progress** via Progress Bar and status messages
4. **Wait for completion** - the system will notify when import is finished

### File Management
- **Delete files**: Click "Delete" button to remove unwanted files
- **View list**: The system displays all files in the upload directory

## ⚙️ Advanced Configuration

### Adjust Maximum File Size
```php
$max_file_size = 1024*1024*256; // Increase to 256MB
```

### Adjust Processing Speed
```php
$lines_per_session = 500;  // Slower but uses less memory
$lines_per_session = 2000; // Faster but uses more memory
```

### Change Upload Directory
```php
$upload_dir = '/path/to/your/upload/folder';
```

## 🔒 Security Features

- **File Extension Validation**: Only allows `.sql` files
- **File Size Limitation**: Prevents oversized file uploads
- **Filename Sanitization**: Prevents path traversal attacks
- **Session Management**: Uses PHP sessions for state management

## 🐛 Troubleshooting

### File Upload Issues
- Check write permissions in the upload directory
- Verify file size is within limits
- Ensure file extension is `.sql`

### Import Issues
- Check database connection settings
- Verify database user permissions
- Validate SQL file format

### Memory Issues
- Reduce `$lines_per_session` value
- Increase `memory_limit` in PHP
- Split large SQL files into smaller chunks

## 📝 Usage Examples

```bash
# Use PHP Built-in server for testing
php -S localhost:8000 cc-sql-bigdump.php
```

## 🤝 Support

If you encounter issues or have questions:
- Check PHP error logs
- Check MySQL error logs
- Test database connection separately

## 📄 License

This project is open source and free to use.

---

**Note**: Use this tool in a secure environment and always backup your data before importing.

## 🌐 Language Support

This tool supports multiple languages and can be easily localized by modifying the text strings in the PHP file.

## 🔧 Customization

The tool is designed to be easily customizable:
- Modify CSS for different themes
- Add new features via JavaScript
- Extend PHP functionality for specific needs

## 📊 Performance Tips

- Use SSD storage for better I/O performance
- Optimize MySQL settings for large imports
- Consider using MySQL's `LOAD DATA INFILE` for very large files
- Monitor server resources during large imports

- # BigDump Modern SQL Importer

เครื่องมือนำเข้าไฟล์ SQL แบบทันสมัยด้วย PHP และ JavaScript ที่มี UI สวยงามและใช้งานง่าย

## ✨ คุณสมบัติ

- **Drag & Drop**: ลากไฟล์ SQL มาวางได้เลย
- **Dark Mode**: โหมดมืดสำหรับการใช้งานในเวลากลางคืน
- **Progress Tracking**: แสดงความคืบหน้าการนำเข้าแบบ Real-time
- **Batch Processing**: ประมวลผลทีละส่วนเพื่อป้องกัน Memory Overflow
- **Error Handling**: จัดการข้อผิดพลาดและแสดงผลลัพธ์
- **Responsive Design**: รองรับการใช้งานบนมือถือและแท็บเล็ต
- **File Management**: จัดการไฟล์ (อัปโหลด, ลบ, นำเข้า)

## 🚀 การติดตั้ง

1. **คัดลอกไฟล์** `cc-sql-bigdump.php` ไปยังเซิร์ฟเวอร์ของคุณ
2. **แก้ไขการตั้งค่า** ในส่วน CONFIG ของไฟล์:

```php
$db_host = 'localhost';        // โฮสต์ฐานข้อมูล
$db_user = 'your_username';    // ชื่อผู้ใช้ฐานข้อมูล
$db_pass = 'your_password';    // รหัสผ่านฐานข้อมูล
$db_name = 'your_database';    // ชื่อฐานข้อมูล
$upload_dir = __DIR__;         // โฟลเดอร์สำหรับเก็บไฟล์
$lines_per_session = 1000;     // จำนวนบรรทัดต่อรอบการประมวลผล
$max_file_size = 1024*1024*128; // ขนาดไฟล์สูงสุด (128MB)
```

3. **เปิดไฟล์** ผ่านเว็บเบราว์เซอร์: `http://your-domain.com/cc-sql-bigdump.php`

## 📋 ความต้องการของระบบ

- **PHP 7.0+** พร้อม MySQLi extension
- **MySQL/MariaDB** ฐานข้อมูล
- **เว็บเซิร์ฟเวอร์** (Apache, Nginx, หรือ PHP Built-in server)
- **สิทธิ์การเขียนไฟล์** ในโฟลเดอร์ที่กำหนด

## 🎯 วิธีการใช้งาน

### การอัปโหลดไฟล์
1. **ลากไฟล์** `.sql` มาวางในพื้นที่ Drop Zone
2. หรือ **คลิกปุ่ม "เลือกไฟล์"** เพื่อเลือกไฟล์จากเครื่อง
3. ระบบจะอัปโหลดไฟล์และแสดงในรายการ

### การนำเข้าข้อมูล
1. **คลิกปุ่ม "นำเข้า"** ที่ไฟล์ที่ต้องการ
2. ระบบจะประมวลผลทีละส่วน (1000 บรรทัดต่อรอบ)
3. **ติดตามความคืบหน้า** จาก Progress Bar และข้อความสถานะ
4. **รอจนเสร็จสิ้น** ระบบจะแจ้งเตือนเมื่อนำเข้าสำเร็จ

### การจัดการไฟล์
- **ลบไฟล์**: คลิกปุ่ม "ลบ" เพื่อลบไฟล์ที่ไม่ต้องการ
- **ดูรายการ**: ระบบจะแสดงไฟล์ทั้งหมดที่มีในโฟลเดอร์

## ⚙️ การตั้งค่าขั้นสูง

### ปรับขนาดไฟล์สูงสุด
```php
$max_file_size = 1024*1024*256; // เพิ่มเป็น 256MB
```

### ปรับความเร็วการประมวลผล
```php
$lines_per_session = 500;  // ช้าลง แต่ใช้ Memory น้อย
$lines_per_session = 2000; // เร็วขึ้น แต่ใช้ Memory มากขึ้น
```

### เปลี่ยนโฟลเดอร์เก็บไฟล์
```php
$upload_dir = '/path/to/your/upload/folder';
```

## 🔒 ความปลอดภัย

- **ตรวจสอบนามสกุลไฟล์**: อนุญาตเฉพาะไฟล์ `.sql`
- **จำกัดขนาดไฟล์**: ป้องกันการอัปโหลดไฟล์ใหญ่เกินไป
- **Sanitize ชื่อไฟล์**: ป้องกัน Path Traversal
- **Session Management**: ใช้ PHP Session สำหรับการจัดการ

## 🐛 การแก้ไขปัญหา

### ไฟล์อัปโหลดไม่ได้
- ตรวจสอบสิทธิ์การเขียนไฟล์ในโฟลเดอร์
- ตรวจสอบขนาดไฟล์ไม่เกินที่กำหนด
- ตรวจสอบนามสกุลไฟล์เป็น `.sql`

### นำเข้าข้อมูลไม่ได้
- ตรวจสอบการเชื่อมต่อฐานข้อมูล
- ตรวจสอบสิทธิ์ผู้ใช้ฐานข้อมูล
- ตรวจสอบไฟล์ SQL ว่าถูกต้อง

### ข้อผิดพลาด Memory
- ลดค่า `$lines_per_session`
- เพิ่ม `memory_limit` ใน PHP
- แบ่งไฟล์ SQL เป็นไฟล์ย่อย

## 📝 ตัวอย่างการใช้งาน

```bash
# ใช้ PHP Built-in server สำหรับทดสอบ
php -S localhost:8000 cc-sql-bigdump.php
```

## 🤝 การสนับสนุน

หากพบปัญหาข้อสงสัย สามารถ:
- ตรวจสอบ Error Log ของ PHP
- ตรวจสอบ Error Log ของ MySQL
- ทดสอบการเชื่อมต่อฐานข้อมูลแยก

## 📄 License

โปรเจกต์นี้เป็น Open Source และสามารถใช้งานได้อย่างอิสระ

---

**หมายเหตุ**: ควรใช้เครื่องมือนี้ในสภาพแวดล้อมที่ปลอดภัยและมีการสำรองข้อมูลก่อนใช้งาน
