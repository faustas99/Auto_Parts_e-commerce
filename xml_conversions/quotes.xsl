<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema"
    exclude-result-prefixes="xs"
    version="2.0">
    
    <xsl:template match="/">
        <html> 
            <body>
                <h2>Quotes</h2>
                <table border="1">
                    <tr bgcolor="#9acd32">
                        <th style="text-align:left">Text</th>
                        <th style="text-align:left">Source</th>
                        <th style="text-align:left">Dob-Dod</th>
                        <th style="text-align:left">wplink</th>
                        <th style="text-align:left">wpImage</th>
                    </tr>
                    <xsl:for-each select="quotes/quote">
                        <tr>
                            <td><xsl:value-of select="text"/></td>
                            <td><xsl:value-of select="source"/></td>
                            <td><xsl:value-of select="dob-dod"/></td>
                            <td><xsl:value-of select="wplink"/></td>
                            <td><img>
                                <xsl:attribute name="src">
                                    <xsl:value-of select="wpimg"/>
                                </xsl:attribute>
                            </img>
                            </td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
    
</xsl:stylesheet>