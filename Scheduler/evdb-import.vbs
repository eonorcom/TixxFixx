Call LogEntry()
 
Sub LogEntry()
 
        On Error Resume Next
 
        Dim objRequest
        Dim URL
 
        Set objRequest = CreateObject("Microsoft.XMLHTTP")
        URL = "http://www.tixxfixx.com/Classes/import/evdb.import.php"
 
        objRequest.open "POST", URL , false
 
        objRequest.Send
 
        Set objRequest = Nothing
 
End Sub