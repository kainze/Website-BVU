var start = "&#109;&#097;&#105;&#108;&#116;&#111;&#058;";

function printEmail(code)
{
    var addr = code.replace(/%%1%%/g, "@").replace(/%%2%%/g, ".");
    document.write(addr);
}

function printEmailLink(code)
{
    var addr = code.replace(/%%1%%/g, "@").replace(/%%2%%/g, ".");
    document.write("<a href='" + start + addr + "'>" + addr + "</a>");
}
