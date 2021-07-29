<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema"
    exclude-result-prefixes="xs"
    version="2.0">

    <xsl:template match="books">
        <html>
            <head>
                <title> Table</title>
            </head>
            <body>
                <table style="width: 100%;" class="auto-style3">
                   
                    <xsl:apply-templates select="books"/>
                </table>
            </body>
        </html>
    </xsl:template>
    <xsl:template match="book">
        <tbody>
            <tr style="background-color: #bbbbbb;">
                <td><strong>category</strong></td>
                <td><strong>quote</strong></td>
                <td><strong>author</strong></td>
                <td><strong>dob-dod</strong></td>
                <td><strong>wiki link</strong></td>
                <td><strong>image</strong></td>
            </tr>
            <tr>
                <td valign="top">romantic</td>
                <td valign="top" style="border-width: 1px">There is no remedy but to love more.</td>
                <td valign="top">Henry David Thoreau</td>
                <td valign="top">1817-1862</td>
                <td valign="top"><a href="http://en.wikipedia.org/wiki/Henry_David_Thoreau">http://en.wikipedia.org/wiki/Henry_David_Thoreau</a></td>
                <td><img src="http://upload.wikimedia.org/wikipedia/commons/f/f0/Benjamin_D._Maxham_-_Henry_David_Thoreau_-_Restored.jpg" width="80"/></td>
                <td/>
            </tr>
            
        </tbody>
    </xsl:template>
</xsl:stylesheet>