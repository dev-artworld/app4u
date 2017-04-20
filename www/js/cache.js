    var reader;
    var text;
    var myFileSystem;
    
    document.addEventListener("deviceready", onDeviceReady, false);
   
    function onDeviceReady() {
	//window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotFS, fail);
	//	setTimeout(readCachefile,5000);
	
        sysLoad();
    }
    
    function myfile() {
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, gotmyFS, fail);
    }
    
    
    function readCachefile() {
	
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, readCacheFS, fail);
    }
    function readCacheFS(fileSystem) {
	
	fileSystem.root.getFile("cache.txt", {create: true, exclusive: false}, readFileEntry, fail);
    }
    function readFileEntry(fileEntry) {
	
	fileEntry.file(readFile, fail);
    }
    function readFile(file){
      
	readAsText(file);
    }
    
    
    
    
    function writeCachefile() {
	window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, writeCacheFS, fail);
    }
    function writeCacheFS(fileSystem) {
	fileSystem.root.getFile("cache.txt", {create: true, exclusive: false}, writeFileEntry, fail);
    }
    function writeFileEntry(fileEntry) {
	fileEntry.createWriter(gotFileWriter, fail);
    }
    
    
    
    function gotFS(fileSystem) {
	fileSystem.root.getFile("cache.txt", {create: true, exclusive: false}, gotFileEntry, fail);
	myFileSystem = fileSystem;
	//alert(fileSystem.name);
    }
    
    function gotmyFS(fileSystem) {
	fileSystem.root.getFile("cache.txt", {create: true, exclusive: false}, gotFileEntry, fail);
    }
    
    function gotFileEntry(fileEntry) {
	fileEntry.createWriter(gotFileWriter, fail);
	fileEntry.file(gotFile, fail);
    }
    
    function gotFileWriter(writer) {
	writer.write(JSON.stringify(cache));
    }
    
    function gotFile(file){
      
	readAsText(file);
    }
    
    function readDataUrl(file) {
	reader = new FileReader();
	reader.onloadend = function(evt) {
	    //alert("Read as data URL");
	    //alert(evt.target.result);
	};
	reader.readAsDataURL(file);
    }
    
    function readAsText(file) {
	reader = new FileReader();
	reader.onloadend = function(evt) {
	    //alert("Read as text");
	    //alert(evt.target.result);
	    text = evt.target.result;
	    if(text!='')
		cache=JSON.parse(text);	    
	    sysLoad();
	    
	};
	reader.readAsText(file);
    }
    function fail(error) {
	alert(error.code);
    }
    