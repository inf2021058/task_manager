<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>Task Lists</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    h1 { color: #2c3e50; }
                    .task_list { margin-bottom: 20px; }
                    .task_list h2 { margin: 0; padding: 0; }
                    .task { margin-left: 20px; }
                </style>
            </head>
            <body>
                <h1>Task Lists</h1>
                <xsl:for-each select="task_lists/task_list">
                    <div class="task_list">
                        <h2><xsl:value-of select="title"/></h2>
                        <p><strong>User:</strong> <xsl:value-of select="user"/></p>
                        <xsl:for-each select="task">
                            <div class="task">
                                <p><strong>Task:</strong> <xsl:value-of select="title"/></p>
                                <p><strong>Status:</strong> <xsl:value-of select="status"/></p>
                            </div>
                        </xsl:for-each>
                    </div>
                </xsl:for-each>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
