<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Create_Student
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container()
        Dim resources As System.ComponentModel.ComponentResourceManager = New System.ComponentModel.ComponentResourceManager(GetType(Create_Student))
        Me.BunifuImageButton1 = New Bunifu.Framework.UI.BunifuImageButton()
        Me.ComboBox1 = New System.Windows.Forms.ComboBox()
        Me.btnUpload = New Bunifu.Framework.UI.BunifuFlatButton()
        Me.btnEdit = New Bunifu.Framework.UI.BunifuFlatButton()
        Me.btnUpdate = New Bunifu.Framework.UI.BunifuFlatButton()
        Me.btnSave = New Bunifu.Framework.UI.BunifuFlatButton()
        Me.btnClear = New Bunifu.Framework.UI.BunifuFlatButton()
        Me.UserPictureBox = New System.Windows.Forms.PictureBox()
        Me.txtTelephone = New Bunifu.Framework.UI.BunifuMetroTextbox()
        Me.txtPassword = New Bunifu.Framework.UI.BunifuMetroTextbox()
        Me.txtUsername = New Bunifu.Framework.UI.BunifuMetroTextbox()
        Me.txtGender = New Bunifu.Framework.UI.BunifuMetroTextbox()
        Me.txtDepartment = New Bunifu.Framework.UI.BunifuMetroTextbox()
        Me.txtOthername = New Bunifu.Framework.UI.BunifuMetroTextbox()
        Me.txtLastname = New Bunifu.Framework.UI.BunifuMetroTextbox()
        Me.txtFirstname = New Bunifu.Framework.UI.BunifuMetroTextbox()
        Me.Panel1 = New System.Windows.Forms.Panel()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.imageOpenFileDialog = New System.Windows.Forms.OpenFileDialog()
        Me.imageElipse = New Bunifu.Framework.UI.BunifuElipse(Me.components)
        CType(Me.BunifuImageButton1, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.UserPictureBox, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'BunifuImageButton1
        '
        Me.BunifuImageButton1.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.BunifuImageButton1.Image = CType(resources.GetObject("BunifuImageButton1.Image"), System.Drawing.Image)
        Me.BunifuImageButton1.ImageActive = Nothing
        Me.BunifuImageButton1.Location = New System.Drawing.Point(414, 191)
        Me.BunifuImageButton1.Name = "BunifuImageButton1"
        Me.BunifuImageButton1.Size = New System.Drawing.Size(71, 44)
        Me.BunifuImageButton1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.CenterImage
        Me.BunifuImageButton1.TabIndex = 37
        Me.BunifuImageButton1.TabStop = False
        Me.BunifuImageButton1.Zoom = 10
        '
        'ComboBox1
        '
        Me.ComboBox1.Font = New System.Drawing.Font("Century Gothic", 21.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.ComboBox1.FormattingEnabled = True
        Me.ComboBox1.Location = New System.Drawing.Point(51, 191)
        Me.ComboBox1.Name = "ComboBox1"
        Me.ComboBox1.Size = New System.Drawing.Size(363, 44)
        Me.ComboBox1.TabIndex = 36
        '
        'btnUpload
        '
        Me.btnUpload.Activecolor = System.Drawing.Color.Red
        Me.btnUpload.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.btnUpload.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Stretch
        Me.btnUpload.BorderRadius = 7
        Me.btnUpload.ButtonText = "Upload Image"
        Me.btnUpload.Cursor = System.Windows.Forms.Cursors.Hand
        Me.btnUpload.DisabledColor = System.Drawing.Color.Gray
        Me.btnUpload.Iconcolor = System.Drawing.Color.Transparent
        Me.btnUpload.Iconimage = Nothing
        Me.btnUpload.Iconimage_right = Nothing
        Me.btnUpload.Iconimage_right_Selected = Nothing
        Me.btnUpload.Iconimage_Selected = Nothing
        Me.btnUpload.IconMarginLeft = 0
        Me.btnUpload.IconMarginRight = 0
        Me.btnUpload.IconRightVisible = True
        Me.btnUpload.IconRightZoom = 0R
        Me.btnUpload.IconVisible = True
        Me.btnUpload.IconZoom = 90.0R
        Me.btnUpload.IsTab = False
        Me.btnUpload.Location = New System.Drawing.Point(863, 680)
        Me.btnUpload.Name = "btnUpload"
        Me.btnUpload.Normalcolor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.btnUpload.OnHovercolor = System.Drawing.Color.Black
        Me.btnUpload.OnHoverTextColor = System.Drawing.Color.White
        Me.btnUpload.selected = False
        Me.btnUpload.Size = New System.Drawing.Size(237, 60)
        Me.btnUpload.TabIndex = 35
        Me.btnUpload.Text = "Upload Image"
        Me.btnUpload.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        Me.btnUpload.Textcolor = System.Drawing.Color.White
        Me.btnUpload.TextFont = New System.Drawing.Font("MingLiU_HKSCS-ExtB", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        '
        'btnEdit
        '
        Me.btnEdit.Activecolor = System.Drawing.Color.Red
        Me.btnEdit.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.btnEdit.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Stretch
        Me.btnEdit.BorderRadius = 7
        Me.btnEdit.ButtonText = "Edit"
        Me.btnEdit.Cursor = System.Windows.Forms.Cursors.Hand
        Me.btnEdit.DisabledColor = System.Drawing.Color.Gray
        Me.btnEdit.Iconcolor = System.Drawing.Color.Transparent
        Me.btnEdit.Iconimage = Nothing
        Me.btnEdit.Iconimage_right = Nothing
        Me.btnEdit.Iconimage_right_Selected = Nothing
        Me.btnEdit.Iconimage_Selected = Nothing
        Me.btnEdit.IconMarginLeft = 0
        Me.btnEdit.IconMarginRight = 0
        Me.btnEdit.IconRightVisible = True
        Me.btnEdit.IconRightZoom = 0R
        Me.btnEdit.IconVisible = True
        Me.btnEdit.IconZoom = 90.0R
        Me.btnEdit.IsTab = False
        Me.btnEdit.Location = New System.Drawing.Point(863, 462)
        Me.btnEdit.Name = "btnEdit"
        Me.btnEdit.Normalcolor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.btnEdit.OnHovercolor = System.Drawing.Color.Black
        Me.btnEdit.OnHoverTextColor = System.Drawing.Color.White
        Me.btnEdit.selected = False
        Me.btnEdit.Size = New System.Drawing.Size(237, 60)
        Me.btnEdit.TabIndex = 34
        Me.btnEdit.Text = "Edit"
        Me.btnEdit.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        Me.btnEdit.Textcolor = System.Drawing.Color.White
        Me.btnEdit.TextFont = New System.Drawing.Font("MingLiU_HKSCS-ExtB", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        '
        'btnUpdate
        '
        Me.btnUpdate.Activecolor = System.Drawing.Color.Red
        Me.btnUpdate.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.btnUpdate.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Stretch
        Me.btnUpdate.BorderRadius = 7
        Me.btnUpdate.ButtonText = "Update"
        Me.btnUpdate.Cursor = System.Windows.Forms.Cursors.Hand
        Me.btnUpdate.DisabledColor = System.Drawing.Color.Gray
        Me.btnUpdate.Iconcolor = System.Drawing.Color.Transparent
        Me.btnUpdate.Iconimage = Nothing
        Me.btnUpdate.Iconimage_right = Nothing
        Me.btnUpdate.Iconimage_right_Selected = Nothing
        Me.btnUpdate.Iconimage_Selected = Nothing
        Me.btnUpdate.IconMarginLeft = 0
        Me.btnUpdate.IconMarginRight = 0
        Me.btnUpdate.IconRightVisible = True
        Me.btnUpdate.IconRightZoom = 0R
        Me.btnUpdate.IconVisible = True
        Me.btnUpdate.IconZoom = 90.0R
        Me.btnUpdate.IsTab = False
        Me.btnUpdate.Location = New System.Drawing.Point(863, 388)
        Me.btnUpdate.Name = "btnUpdate"
        Me.btnUpdate.Normalcolor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.btnUpdate.OnHovercolor = System.Drawing.Color.Black
        Me.btnUpdate.OnHoverTextColor = System.Drawing.Color.White
        Me.btnUpdate.selected = False
        Me.btnUpdate.Size = New System.Drawing.Size(237, 60)
        Me.btnUpdate.TabIndex = 33
        Me.btnUpdate.Text = "Update"
        Me.btnUpdate.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        Me.btnUpdate.Textcolor = System.Drawing.Color.White
        Me.btnUpdate.TextFont = New System.Drawing.Font("MingLiU_HKSCS-ExtB", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        '
        'btnSave
        '
        Me.btnSave.Activecolor = System.Drawing.Color.Red
        Me.btnSave.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.btnSave.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Stretch
        Me.btnSave.BorderRadius = 7
        Me.btnSave.ButtonText = "Save"
        Me.btnSave.Cursor = System.Windows.Forms.Cursors.Hand
        Me.btnSave.DisabledColor = System.Drawing.Color.Gray
        Me.btnSave.Iconcolor = System.Drawing.Color.Transparent
        Me.btnSave.Iconimage = Nothing
        Me.btnSave.Iconimage_right = Nothing
        Me.btnSave.Iconimage_right_Selected = Nothing
        Me.btnSave.Iconimage_Selected = Nothing
        Me.btnSave.IconMarginLeft = 0
        Me.btnSave.IconMarginRight = 0
        Me.btnSave.IconRightVisible = True
        Me.btnSave.IconRightZoom = 0R
        Me.btnSave.IconVisible = True
        Me.btnSave.IconZoom = 90.0R
        Me.btnSave.IsTab = False
        Me.btnSave.Location = New System.Drawing.Point(863, 606)
        Me.btnSave.Name = "btnSave"
        Me.btnSave.Normalcolor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.btnSave.OnHovercolor = System.Drawing.Color.Black
        Me.btnSave.OnHoverTextColor = System.Drawing.Color.White
        Me.btnSave.selected = False
        Me.btnSave.Size = New System.Drawing.Size(237, 60)
        Me.btnSave.TabIndex = 32
        Me.btnSave.Text = "Save"
        Me.btnSave.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        Me.btnSave.Textcolor = System.Drawing.Color.White
        Me.btnSave.TextFont = New System.Drawing.Font("MingLiU_HKSCS-ExtB", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        '
        'btnClear
        '
        Me.btnClear.Activecolor = System.Drawing.Color.Red
        Me.btnClear.BackColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.btnClear.BackgroundImageLayout = System.Windows.Forms.ImageLayout.Stretch
        Me.btnClear.BorderRadius = 7
        Me.btnClear.ButtonText = "Clear"
        Me.btnClear.Cursor = System.Windows.Forms.Cursors.Hand
        Me.btnClear.DisabledColor = System.Drawing.Color.Gray
        Me.btnClear.Iconcolor = System.Drawing.Color.Transparent
        Me.btnClear.Iconimage = Nothing
        Me.btnClear.Iconimage_right = Nothing
        Me.btnClear.Iconimage_right_Selected = Nothing
        Me.btnClear.Iconimage_Selected = Nothing
        Me.btnClear.IconMarginLeft = 0
        Me.btnClear.IconMarginRight = 0
        Me.btnClear.IconRightVisible = True
        Me.btnClear.IconRightZoom = 0R
        Me.btnClear.IconVisible = True
        Me.btnClear.IconZoom = 90.0R
        Me.btnClear.IsTab = False
        Me.btnClear.Location = New System.Drawing.Point(863, 538)
        Me.btnClear.Name = "btnClear"
        Me.btnClear.Normalcolor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.btnClear.OnHovercolor = System.Drawing.Color.Black
        Me.btnClear.OnHoverTextColor = System.Drawing.Color.White
        Me.btnClear.selected = False
        Me.btnClear.Size = New System.Drawing.Size(237, 60)
        Me.btnClear.TabIndex = 31
        Me.btnClear.Text = "Clear"
        Me.btnClear.TextAlign = System.Drawing.ContentAlignment.MiddleCenter
        Me.btnClear.Textcolor = System.Drawing.Color.White
        Me.btnClear.TextFont = New System.Drawing.Font("MingLiU_HKSCS-ExtB", 15.75!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        '
        'UserPictureBox
        '
        Me.UserPictureBox.Image = CType(resources.GetObject("UserPictureBox.Image"), System.Drawing.Image)
        Me.UserPictureBox.Location = New System.Drawing.Point(538, 431)
        Me.UserPictureBox.Name = "UserPictureBox"
        Me.UserPictureBox.Size = New System.Drawing.Size(276, 277)
        Me.UserPictureBox.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.UserPictureBox.TabIndex = 30
        Me.UserPictureBox.TabStop = False
        '
        'txtTelephone
        '
        Me.txtTelephone.BorderColorFocused = System.Drawing.Color.Red
        Me.txtTelephone.BorderColorIdle = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtTelephone.BorderColorMouseHover = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.txtTelephone.BorderThickness = 1
        Me.txtTelephone.Cursor = System.Windows.Forms.Cursors.IBeam
        Me.txtTelephone.Font = New System.Drawing.Font("Century Gothic", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtTelephone.ForeColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtTelephone.isPassword = False
        Me.txtTelephone.Location = New System.Drawing.Point(51, 783)
        Me.txtTelephone.Margin = New System.Windows.Forms.Padding(6, 5, 6, 5)
        Me.txtTelephone.Name = "txtTelephone"
        Me.txtTelephone.Size = New System.Drawing.Size(434, 53)
        Me.txtTelephone.TabIndex = 29
        Me.txtTelephone.Text = "Telephone"
        Me.txtTelephone.TextAlign = System.Windows.Forms.HorizontalAlignment.Left
        '
        'txtPassword
        '
        Me.txtPassword.BorderColorFocused = System.Drawing.Color.Red
        Me.txtPassword.BorderColorIdle = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtPassword.BorderColorMouseHover = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.txtPassword.BorderThickness = 1
        Me.txtPassword.Cursor = System.Windows.Forms.Cursors.IBeam
        Me.txtPassword.Font = New System.Drawing.Font("Century Gothic", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtPassword.ForeColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtPassword.isPassword = False
        Me.txtPassword.Location = New System.Drawing.Point(51, 709)
        Me.txtPassword.Margin = New System.Windows.Forms.Padding(6, 5, 6, 5)
        Me.txtPassword.Name = "txtPassword"
        Me.txtPassword.Size = New System.Drawing.Size(434, 53)
        Me.txtPassword.TabIndex = 28
        Me.txtPassword.Text = "Password"
        Me.txtPassword.TextAlign = System.Windows.Forms.HorizontalAlignment.Left
        '
        'txtUsername
        '
        Me.txtUsername.BorderColorFocused = System.Drawing.Color.Red
        Me.txtUsername.BorderColorIdle = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtUsername.BorderColorMouseHover = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.txtUsername.BorderThickness = 1
        Me.txtUsername.Cursor = System.Windows.Forms.Cursors.IBeam
        Me.txtUsername.Font = New System.Drawing.Font("Century Gothic", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtUsername.ForeColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtUsername.isPassword = False
        Me.txtUsername.Location = New System.Drawing.Point(51, 630)
        Me.txtUsername.Margin = New System.Windows.Forms.Padding(6, 5, 6, 5)
        Me.txtUsername.Name = "txtUsername"
        Me.txtUsername.Size = New System.Drawing.Size(434, 53)
        Me.txtUsername.TabIndex = 27
        Me.txtUsername.Text = "Username"
        Me.txtUsername.TextAlign = System.Windows.Forms.HorizontalAlignment.Left
        '
        'txtGender
        '
        Me.txtGender.BorderColorFocused = System.Drawing.Color.Red
        Me.txtGender.BorderColorIdle = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtGender.BorderColorMouseHover = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.txtGender.BorderThickness = 1
        Me.txtGender.Cursor = System.Windows.Forms.Cursors.IBeam
        Me.txtGender.Font = New System.Drawing.Font("Century Gothic", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtGender.ForeColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtGender.isPassword = False
        Me.txtGender.Location = New System.Drawing.Point(51, 556)
        Me.txtGender.Margin = New System.Windows.Forms.Padding(6, 5, 6, 5)
        Me.txtGender.Name = "txtGender"
        Me.txtGender.Size = New System.Drawing.Size(434, 53)
        Me.txtGender.TabIndex = 26
        Me.txtGender.Text = "Gender"
        Me.txtGender.TextAlign = System.Windows.Forms.HorizontalAlignment.Left
        '
        'txtDepartment
        '
        Me.txtDepartment.BorderColorFocused = System.Drawing.Color.Red
        Me.txtDepartment.BorderColorIdle = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtDepartment.BorderColorMouseHover = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.txtDepartment.BorderThickness = 1
        Me.txtDepartment.Cursor = System.Windows.Forms.Cursors.IBeam
        Me.txtDepartment.Font = New System.Drawing.Font("Century Gothic", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtDepartment.ForeColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtDepartment.isPassword = False
        Me.txtDepartment.Location = New System.Drawing.Point(51, 476)
        Me.txtDepartment.Margin = New System.Windows.Forms.Padding(6, 5, 6, 5)
        Me.txtDepartment.Name = "txtDepartment"
        Me.txtDepartment.Size = New System.Drawing.Size(434, 53)
        Me.txtDepartment.TabIndex = 25
        Me.txtDepartment.Text = "Department"
        Me.txtDepartment.TextAlign = System.Windows.Forms.HorizontalAlignment.Left
        '
        'txtOthername
        '
        Me.txtOthername.BorderColorFocused = System.Drawing.Color.Red
        Me.txtOthername.BorderColorIdle = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtOthername.BorderColorMouseHover = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.txtOthername.BorderThickness = 1
        Me.txtOthername.Cursor = System.Windows.Forms.Cursors.IBeam
        Me.txtOthername.Font = New System.Drawing.Font("Century Gothic", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtOthername.ForeColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtOthername.isPassword = False
        Me.txtOthername.Location = New System.Drawing.Point(51, 399)
        Me.txtOthername.Margin = New System.Windows.Forms.Padding(6, 5, 6, 5)
        Me.txtOthername.Name = "txtOthername"
        Me.txtOthername.Size = New System.Drawing.Size(434, 53)
        Me.txtOthername.TabIndex = 24
        Me.txtOthername.Text = "Othername"
        Me.txtOthername.TextAlign = System.Windows.Forms.HorizontalAlignment.Left
        '
        'txtLastname
        '
        Me.txtLastname.BorderColorFocused = System.Drawing.Color.Red
        Me.txtLastname.BorderColorIdle = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtLastname.BorderColorMouseHover = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.txtLastname.BorderThickness = 1
        Me.txtLastname.Cursor = System.Windows.Forms.Cursors.IBeam
        Me.txtLastname.Font = New System.Drawing.Font("Century Gothic", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtLastname.ForeColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtLastname.isPassword = False
        Me.txtLastname.Location = New System.Drawing.Point(51, 327)
        Me.txtLastname.Margin = New System.Windows.Forms.Padding(6, 5, 6, 5)
        Me.txtLastname.Name = "txtLastname"
        Me.txtLastname.Size = New System.Drawing.Size(434, 53)
        Me.txtLastname.TabIndex = 23
        Me.txtLastname.Text = "Lastname"
        Me.txtLastname.TextAlign = System.Windows.Forms.HorizontalAlignment.Left
        '
        'txtFirstname
        '
        Me.txtFirstname.BorderColorFocused = System.Drawing.Color.Red
        Me.txtFirstname.BorderColorIdle = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtFirstname.BorderColorMouseHover = System.Drawing.Color.FromArgb(CType(CType(192, Byte), Integer), CType(CType(0, Byte), Integer), CType(CType(0, Byte), Integer))
        Me.txtFirstname.BorderThickness = 1
        Me.txtFirstname.Cursor = System.Windows.Forms.Cursors.IBeam
        Me.txtFirstname.Font = New System.Drawing.Font("Century Gothic", 12.0!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.txtFirstname.ForeColor = System.Drawing.Color.FromArgb(CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer), CType(CType(64, Byte), Integer))
        Me.txtFirstname.isPassword = False
        Me.txtFirstname.Location = New System.Drawing.Point(51, 258)
        Me.txtFirstname.Margin = New System.Windows.Forms.Padding(6, 5, 6, 5)
        Me.txtFirstname.Name = "txtFirstname"
        Me.txtFirstname.Size = New System.Drawing.Size(434, 53)
        Me.txtFirstname.TabIndex = 22
        Me.txtFirstname.Text = "Firstname"
        Me.txtFirstname.TextAlign = System.Windows.Forms.HorizontalAlignment.Left
        '
        'Panel1
        '
        Me.Panel1.BackColor = System.Drawing.Color.Red
        Me.Panel1.Location = New System.Drawing.Point(596, 82)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(210, 3)
        Me.Panel1.TabIndex = 21
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Font = New System.Drawing.Font("MingLiU-ExtB", 45.0!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.ForeColor = System.Drawing.Color.Red
        Me.Label2.Location = New System.Drawing.Point(275, 21)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(552, 60)
        Me.Label2.TabIndex = 20
        Me.Label2.Text = "STUDENT'S ACCOUNT"
        '
        'imageOpenFileDialog
        '
        Me.imageOpenFileDialog.FileName = "imageOpenFileDialog"
        '
        'imageElipse
        '
        Me.imageElipse.ElipseRadius = 5000
        Me.imageElipse.TargetControl = Me.UserPictureBox
        '
        'Create_Student
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.BackColor = System.Drawing.Color.White
        Me.ClientSize = New System.Drawing.Size(1148, 1022)
        Me.Controls.Add(Me.BunifuImageButton1)
        Me.Controls.Add(Me.ComboBox1)
        Me.Controls.Add(Me.btnUpload)
        Me.Controls.Add(Me.btnEdit)
        Me.Controls.Add(Me.btnUpdate)
        Me.Controls.Add(Me.btnSave)
        Me.Controls.Add(Me.btnClear)
        Me.Controls.Add(Me.UserPictureBox)
        Me.Controls.Add(Me.txtTelephone)
        Me.Controls.Add(Me.txtPassword)
        Me.Controls.Add(Me.txtUsername)
        Me.Controls.Add(Me.txtGender)
        Me.Controls.Add(Me.txtDepartment)
        Me.Controls.Add(Me.txtOthername)
        Me.Controls.Add(Me.txtLastname)
        Me.Controls.Add(Me.txtFirstname)
        Me.Controls.Add(Me.Panel1)
        Me.Controls.Add(Me.Label2)
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None
        Me.Name = "Create_Student"
        Me.Text = "Create_Student"
        CType(Me.BunifuImageButton1, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.UserPictureBox, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub

    Friend WithEvents BunifuImageButton1 As Bunifu.Framework.UI.BunifuImageButton
    Friend WithEvents ComboBox1 As ComboBox
    Friend WithEvents btnUpload As Bunifu.Framework.UI.BunifuFlatButton
    Friend WithEvents btnEdit As Bunifu.Framework.UI.BunifuFlatButton
    Friend WithEvents btnUpdate As Bunifu.Framework.UI.BunifuFlatButton
    Friend WithEvents btnSave As Bunifu.Framework.UI.BunifuFlatButton
    Friend WithEvents btnClear As Bunifu.Framework.UI.BunifuFlatButton
    Friend WithEvents UserPictureBox As PictureBox
    Friend WithEvents txtTelephone As Bunifu.Framework.UI.BunifuMetroTextbox
    Friend WithEvents txtPassword As Bunifu.Framework.UI.BunifuMetroTextbox
    Friend WithEvents txtUsername As Bunifu.Framework.UI.BunifuMetroTextbox
    Friend WithEvents txtGender As Bunifu.Framework.UI.BunifuMetroTextbox
    Friend WithEvents txtDepartment As Bunifu.Framework.UI.BunifuMetroTextbox
    Friend WithEvents txtOthername As Bunifu.Framework.UI.BunifuMetroTextbox
    Friend WithEvents txtLastname As Bunifu.Framework.UI.BunifuMetroTextbox
    Friend WithEvents txtFirstname As Bunifu.Framework.UI.BunifuMetroTextbox
    Friend WithEvents Panel1 As Panel
    Friend WithEvents Label2 As Label
    Friend WithEvents imageOpenFileDialog As OpenFileDialog
    Friend WithEvents imageElipse As Bunifu.Framework.UI.BunifuElipse
End Class
