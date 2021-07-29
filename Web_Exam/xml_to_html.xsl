<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" indent="yes"/>
	<xsl:template match="/">
		<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html>&#10;</xsl:text>
		<html>
			<head>
				<title>Quotes XML -> HTML using XSLT example</title>
				<style>
					tr:nth-child(odd){
					    background-color:#eeeeee;
					}
					table {
					    width:80%;
					    text-align:left;
					    margin: auto;
					}
					td {
						vertical-align:top;
					}
				</style>
			</head>
			<body>
				<table>
					<tr>
                        <th>cat</th>
                        <th>text</th>
                        <th>name</th>
                        <th>dob</th>
                        <th>dod</th>
                        <th>wplink</th>
                        <th>wpimg</th>
                    </tr>
					
					<xsl:for-each select="/quotes/quote">
						<tr>
							<td><xsl:value-of select="./@cat"/></td>
							<xsl:call-template name="tableBody"/>
						</tr>
					</xsl:for-each>
				</table>
			</body>
		</html>
	</xsl:template>
	
	<xsl:template name="tableBody">
		<td><xsl:value-of select="./text"/></td>
		<xsl:for-each select="./author/*">
			<xsl:choose>
				<xsl:when test="local-name()='wplink'">
					<td>
						<a>
							<xsl:attribute name="href">
								<xsl:value-of select="."/>
							</xsl:attribute>
							<xsl:value-of select="."/>
						</a>
					</td>
				</xsl:when>
				<xsl:when test="local-name()='wpimg'">
					<td>
						<img width="110">
							<xsl:attribute name="src">
								<xsl:value-of select="."/>
							</xsl:attribute>
						</img>
					</td>
				</xsl:when>
				<xsl:otherwise>
					<td>
						<xsl:value-of select="."/>
					</td>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>