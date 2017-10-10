<form action="/message/send" method="post">
    <input type="hidden" name="login" id="login" value="<?php echo $user->name ?>"
           class="form-control"/>
    <div class="form-group">
        <!--<div contenteditable="" id="editor" onkeypress="updateTextarea()" style="width: 100%; height: 200px; border: 1px solid grey;font-size:<?php echo Auth::user()->getProperty('mail_settings_font_size', 12) ?>px"></div>-->
        <textarea name="message" id="message" onblur="doBlur(this)" class="form-control" style=""></textarea>
    </div>
    {{ csrf_field() }}
    <div class="btn-group" role="group" aria-label="Опции редактора">
        <a class="btn btn-default"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
        <a onmousedown="insertAtCursor(document.getElementById('editor'), '<b>' + getSelectionText() + '</b>')" class="btn btn-default"><i class="fa fa-bold" aria-hidden="true"></i></a>
        <a onclick="insertAtCursor(document.getElementById('editor'), '☺')" class="btn btn-default"><i class="fa fa-smile-o" aria-hidden="true"></i></a>
    </div>
    <div class="form-group ">
        <button type="submit" class="pull-right btn btn-success">Отправить</button>
    </div>
</form>
<script>
    function updateTextarea() {
        document.getElementById('message').value = document.getElementById('editor').innerHTML;
    }

    function insertAtCursor(myField, myValue) {
            //IE support
       console.log(getCaretPosition(myField));
        updateTextarea();
        return false;
    }

    function getCaretPosition(editableDiv) {
        var caretPos = 0,
            sel, range;
        if (window.getSelection) {
            sel = window.getSelection();
            if (sel.rangeCount) {
                v
                range = sel.getRangeAt(0);
                if (range.commonAncestorContainer.parentNode == editableDiv) {
                    caretPos = range.endOffset;
                }
            }
        } else if (document.selection && document.selection.createRange) {
            range = document.selection.createRange();
            if (range.parentElement() == editableDiv) {
                var tempEl = document.createElement("span");
                editableDiv.insertBefore(tempEl, editableDiv.firstChild);
                var tempRange = range.duplicate();
                tempRange.moveToElementText(tempEl);
                tempRange.setEndPoint("EndToEnd", range);
                caretPos = tempRange.text.length;
                console.log(tempRange);
            }
        }
        return caretPos;
    }

    function getSelectionText() {
        var text = "";
        if (window.getSelection) {
            text = window.getSelection().toString();
        } else if (document.selection && document.selection.type != "Control") {
            text = document.selection.createRange().text;
        }

        return text;
    }

    function doBlur(obj) {
        setTimeout(function() { obj.focus(); }, 100);
    }
</script>
<div class="clearfix"></div><br/>