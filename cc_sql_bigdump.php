<?php
// ================== CONFIG ==================
$db_host = 'localhost';
$db_user = 'dev20_buncha';
$db_pass = 'WAJ7o5KwX';
$db_name = 'dev20_buncha';
$upload_dir = __DIR__;
$lines_per_session = 1000;
$max_file_size = 1024*1024*128; // 128MB per file
session_start();
header('X-Content-Type-Options: nosniff');

// ================== LANGUAGE SYSTEM ==================
$lang = isset($_GET['lang']) ? $_GET['lang'] : (isset($_SESSION['lang']) ? $_SESSION['lang'] : 'th');
$_SESSION['lang'] = $lang;

$translations = [
    'th' => [
        'title' => 'BigDump Modern',
        'subtitle' => 'SQL Importer',
        'dropzone_text' => 'ลากไฟล์ .sql มาวางที่นี่ หรือ',
        'choose_file' => 'เลือกไฟล์',
        'upload_success' => 'อัปโหลดสำเร็จ',
        'uploading' => 'กำลังอัปโหลด...',
        'import' => 'นำเข้า',
        'delete' => 'ลบ',
        'importing' => 'กำลังนำเข้า...',
        'imported_queries' => 'นำเข้าแล้ว',
        'import_complete' => 'นำเข้าเสร็จสิ้น!',
        'file_deleted' => 'ลบไฟล์แล้ว',
        'file_not_found' => 'ไม่พบไฟล์',
        'sql_only' => 'อนุญาตเฉพาะไฟล์ .sql',
        'file_too_large' => 'ไฟล์ใหญ่เกินไป (สูงสุด 128MB)',
        'dark_mode' => 'Toggle dark mode',
        'language' => 'Language'
    ],
    'en' => [
        'title' => 'BigDump Modern',
        'subtitle' => 'SQL Importer',
        'dropzone_text' => 'Drag .sql files here or',
        'choose_file' => 'Choose File',
        'upload_success' => 'Upload successful',
        'uploading' => 'Uploading...',
        'import' => 'Import',
        'delete' => 'Delete',
        'importing' => 'Importing...',
        'imported_queries' => 'Imported',
        'import_complete' => 'Import complete!',
        'file_deleted' => 'File deleted',
        'file_not_found' => 'File not found',
        'sql_only' => 'Only .sql files allowed',
        'file_too_large' => 'File too large (max 128MB)',
        'dark_mode' => 'Toggle dark mode',
        'language' => 'ภาษา'
    ]
];

$t = $translations[$lang];

function t($key) {
    global $t;
    return isset($t[$key]) ? $t[$key] : $key;
}
// ================== AJAX HANDLER ==================
if (isset($_GET['ajax'])) {
    if ($_GET['ajax'] === 'upload' && isset($_FILES['file'])) {
        $f = $_FILES['file'];
        if (!preg_match('/\.sql$/i', $f['name'])) die(json_encode(['error'=>t('sql_only')]));
        if ($f['size'] > $max_file_size) die(json_encode(['error'=>t('file_too_large')]));
        $fname = uniqid('sql_',true).'_'.preg_replace('/[^A-Za-z0-9_.-]/','',$f['name']);
        move_uploaded_file($f['tmp_name'], "$upload_dir/$fname");
        die(json_encode(['success'=>true,'file'=>$fname,'size'=>$f['size']]));
    }
    if ($_GET['ajax'] === 'delete' && isset($_POST['file'])) {
        $f = basename($_POST['file']);
        if (preg_match('/\.sql$/i', $f) && file_exists("$upload_dir/$f")) {
            unlink("$upload_dir/$f");
            die(json_encode(['success'=>true]));
        }
        die(json_encode(['error'=>t('file_not_found')]));
    }
    if ($_GET['ajax'] === 'import' && isset($_POST['file'])) {
        $file = basename($_POST['file']);
        $filepath = "$upload_dir/$file";
        if (!file_exists($filepath)) die(json_encode(['error'=>t('file_not_found')]));
        $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
        $mysqli->set_charset('utf8mb4');
        $start = isset($_POST['pos']) ? intval($_POST['pos']) : 0;
        $lines = 0; $queries = 0; $errors = [];
        $handle = fopen($filepath, "r");
        fseek($handle, $start);
        $query = '';
        while (!feof($handle) && $lines < $lines_per_session) {
            $line = fgets($handle);
            if ($line === false) break;
            if (trim($line)=='' || strpos(trim($line),'--')===0 || strpos(trim($line),'#')===0) continue;
            $query .= $line;
            if (preg_match('/;\s*$/', trim($line))) {
                if (!$mysqli->query($query)) $errors[] = $mysqli->error;
                $queries++; $query = '';
            }
            $lines++;
        }
        $pos = ftell($handle);
        $done = feof($handle);
        fclose($handle);
        die(json_encode([
            'success'=>true,
            'pos'=>$pos,
            'done'=>$done,
            'queries'=>$queries,
            'errors'=>$errors
        ]));
    }
    if ($_GET['ajax'] === 'list') {
        $files = [];
        foreach (glob("$upload_dir/*.sql") as $f) {
            $files[] = [
                'name'=>basename($f),
                'size'=>filesize($f),
                'mtime'=>date('Y-m-d H:i',filemtime($f))
            ];
        }
        die(json_encode($files));
    }
    die();
}
?><!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo t('title'); ?></title>
<style>
:root {
  --main: #1976d2;
  --accent: #43a047;
  --bg: #f5f5f5;
  --text: #222;
  --error: #d32f2f;
  --success: #388e3c;
}
body { background: var(--bg); color: var(--text); font-family: 'Segoe UI',Arial,sans-serif; margin:0; }
.dark { --main:#222; --bg:#181818; --text:#eee; --accent:#43a047; --error:#ff5252; --success:#00e676; }
.header { display:flex;align-items:center;justify-content:space-between;padding:1em 2em;background:var(--main);color:#fff; }
#dropzone { border:2px dashed var(--main); border-radius:10px; padding:2em; margin:2em auto; max-width:500px; text-align:center; background:#fff; transition:background .2s; }
#dropzone.dragover { background:#e3f2fd; }
input[type=file] { display:none; }
#filelist { max-width:700px; margin:2em auto; }
.filebox { background:#fff; border-radius:8px; box-shadow:0 2px 8px #0001; margin-bottom:1em; padding:1em; display:flex;align-items:center;justify-content:space-between;gap:1em; flex-wrap:wrap; }
.fileinfo { flex:1; }
.progress { width:100%; height:10px; background:#eee; border-radius:5px; overflow:hidden; margin:0.5em 0; }
.progress-bar { height:100%; background:var(--main); transition:width .3s; }
.btn { background:var(--main); color:#fff; border:none; border-radius:4px; padding:0.5em 1.2em; cursor:pointer; font-size:1em; margin-right:0.5em; transition:background .2s; }
.btn:hover { background:var(--accent); }
.btn.del { background:var(--error); }
.btn.del:hover { background:#b71c1c; }
.status { font-size:0.95em; margin-top:0.3em; }
.toast { position:fixed;top:1em;right:1em;z-index:9999; background:var(--main);color:#fff;padding:1em 2em;border-radius:8px;box-shadow:0 2px 8px #0003;opacity:0;pointer-events:none;transition:opacity .4s; }
.toast.show { opacity:1; pointer-events:auto; }
#darkmode, #langswitch { background:none; border:none; color:#fff; font-size:1.5em; cursor:pointer; margin-left:0.5em; }
@media (max-width:600px) {
  .header { flex-direction:column; gap:0.5em; padding:1em; }
  #dropzone, #filelist { max-width:98vw; }
  .filebox { flex-direction:column; align-items:flex-start; }
}
</style>
</head>
<body>
<div class="header">
  <div><b><?php echo t('title'); ?></b> <span style="font-size:0.8em;opacity:0.7;"><?php echo t('subtitle'); ?></span></div>
  <div>
    <button id="langswitch" title="<?php echo t('language'); ?>"><?php echo $lang === 'th' ? '🇺🇸' : '🇹🇭'; ?></button>
    <button id="darkmode" title="<?php echo t('dark_mode'); ?>">🌙</button>
  </div>
</div>
<div id="dropzone"><?php echo t('dropzone_text'); ?> <label class="btn"><input type="file" id="fileinput" multiple><?php echo t('choose_file'); ?></label></div>
<div id="filelist"></div>
<div id="toast" class="toast"></div>
<script>
const dropzone = document.getElementById('dropzone');
const fileinput = document.getElementById('fileinput');
const filelist = document.getElementById('filelist');
const toast = document.getElementById('toast');
const darkBtn = document.getElementById('darkmode');
const langBtn = document.getElementById('langswitch');
// Dark mode toggle
if(localStorage.dark==='1')document.body.classList.add('dark');
darkBtn.onclick=()=>{document.body.classList.toggle('dark');localStorage.dark=document.body.classList.contains('dark')?'1':'0';}

// Language switch
langBtn.onclick=()=>{
    const currentLang = '<?php echo $lang; ?>';
    const newLang = currentLang === 'th' ? 'en' : 'th';
    window.location.href = '?lang=' + newLang;
}
// Toast
function showToast(msg,ok=1){toast.textContent=msg;toast.style.background=ok?"var(--main)":"var(--error)";toast.classList.add('show');setTimeout(()=>toast.classList.remove('show'),3000);}
// Drag & Drop
['dragenter','dragover'].forEach(e=>dropzone.addEventListener(e,ev=>{ev.preventDefault();dropzone.classList.add('dragover');}));
['dragleave','drop'].forEach(e=>dropzone.addEventListener(e,ev=>{ev.preventDefault();dropzone.classList.remove('dragover');}));
dropzone.addEventListener('drop',ev=>{ev.preventDefault();uploadFiles(ev.dataTransfer.files);});
fileinput.onchange=()=>uploadFiles(fileinput.files);
function uploadFiles(files){
  [...files].forEach(f=>{
    if(!f.name.match(/\.sql$/i))return showToast('<?php echo t('sql_only'); ?>',0);
    if(f.size>134217728)return showToast('<?php echo t('file_too_large'); ?>',0);
    let box=addFileBox({name:f.name,size:f.size,uploading:true});
    let fd=new FormData();fd.append('file',f);
    fetch('?ajax=upload',{method:'POST',body:fd}).then(r=>r.json()).then(res=>{
      if(res.success){ box.dataset.file=res.file; box.querySelector('.status').textContent='<?php echo t('upload_success'); ?>'; loadFiles(); }
      else{ box.querySelector('.status').textContent=res.error; showToast(res.error,0); }
    });
  });
}
function addFileBox(f){
  let box=document.createElement('div');box.className='filebox';
  box.innerHTML=`<div class="fileinfo"><b>${f.name}</b> <span style="font-size:0.9em;opacity:0.7;">(${(f.size/1024).toFixed(1)} KB)</span><div class="progress"><div class="progress-bar" style="width:0%"></div></div><div class="status">${f.uploading?'<?php echo t('uploading'); ?>':''}</div></div><div><button class="btn import"><?php echo t('import'); ?></button> <button class="btn del"><?php echo t('delete'); ?></button></div>`;
  filelist.appendChild(box);
  box.querySelector('.del').onclick=()=>deleteFile(box.dataset.file||f.name,box);
  box.querySelector('.import').onclick=()=>startImport(box.dataset.file||f.name,box);
  if(f.uploading)box.querySelector('.import').disabled=true;
  return box;
}
function loadFiles(){
  filelist.innerHTML='';
  fetch('?ajax=list').then(r=>r.json()).then(files=>{
    files.forEach(f=>{
      let box=addFileBox(f); box.dataset.file=f.name;
    });
  });
}
function deleteFile(fname,box){
  if(!fname)return;
  fetch('?ajax=delete',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'file='+encodeURIComponent(fname)}).then(r=>r.json()).then(res=>{
    if(res.success){ showToast('<?php echo t('file_deleted'); ?>'); box.remove(); }
    else showToast(res.error,0);
  });
}
function startImport(fname,box){
  if(!fname)return;
  let pb=box.querySelector('.progress-bar');
  let st=box.querySelector('.status');
  let btn=box.querySelector('.import');
  btn.disabled=true; st.textContent='<?php echo t('importing'); ?>';
  let pos=0, total=0, done=false, allq=0, allerr=0;
  function step(){
    fetch('?ajax=import',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'file='+encodeURIComponent(fname)+'&pos='+pos}).then(r=>r.json()).then(res=>{
      if(res.error){ st.textContent=res.error; showToast(res.error,0); btn.disabled=false; return; }
      pos=res.pos; done=res.done; allq+=res.queries; allerr+=(res.errors||[]).length;
      pb.style.width=Math.min(100,done?100:(pos/box.dataset.size*100||10))+'%';
      st.textContent=`<?php echo t('imported_queries'); ?> ${allq} query${allerr?`, error ${allerr}`:''}`;
      if(!done) setTimeout(step,300);
      else { st.textContent=`<?php echo t('import_complete'); ?> (${allq} query${allerr?`, error ${allerr}`:''})`; showToast('<?php echo t('import_complete'); ?>'); btn.disabled=false; loadFiles(); }
    });
  }
  // ดึงขนาดไฟล์ก่อน
  if(!box.dataset.size){
    fetch('?ajax=list').then(r=>r.json()).then(files=>{
      let f=files.find(x=>x.name==fname); box.dataset.size=f?f.size:1; step();
    });
  }else step();
}
loadFiles();
</script>
</body>
</html> 