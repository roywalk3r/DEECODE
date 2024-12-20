'Importing Sql Library Modulo
Imports System.Data.SqlClient    ' ------- Allowing us to use sql 

Public Class Create_Instructor
    'Database Connection String 
    Dim con = New SqlConnection("Data Source=ROACH\SQL;Initial Catalog=IPMC_Management;Integrated Security=SSPI")
    Private Sub btnUpload_Click(sender As Object, e As EventArgs) Handles btnUpload.Click
        ' ------ Uploading Instructor's image
        If imageOpenFileDialog.ShowDialog = DialogResult.OK Then
            UserPictureBox.ImageLocation = imageOpenFileDialog.FileName
        End If
    End Sub

    Private Sub txtFirstname_Enter(sender As Object, e As EventArgs) Handles txtFirstname.Enter
        ' ------ Placeholder Function
        If (txtFirstname.Text = "Firstname") Then
            txtFirstname.Text = ""

            ' --- changing textcolor
            txtFirstname.ForeColor = Color.Red
        End If
    End Sub

    Private Sub txtFirstname_Leave(sender As Object, e As EventArgs) Handles txtFirstname.Leave
        ' ----- Placeholder Function
        If (txtFirstname.Text = "") Then
            txtFirstname.Text = "Firstname"

            ' --- changing textcolor
            txtFirstname.ForeColor = Color.Black
        End If
    End Sub

    Private Sub txtLastname_Enter(sender As Object, e As EventArgs) Handles txtLastname.Enter
        ' ------ Placeholder Function
        If (txtLastname.Text = "Lastname") Then
            txtLastname.Text = ""

            ' --- changing textcolor
            txtLastname.ForeColor = Color.Red
        End If
    End Sub

    Private Sub txtLastname_Leave(sender As Object, e As EventArgs) Handles txtLastname.Leave
        ' ------ Placehodler Function
        If (txtLastname.Text = "") Then
            txtLastname.Text = "Lastname"

            ' --- changing textcolor
            txtLastname.ForeColor = Color.Black
        End If
    End Sub

    Private Sub txtOthername_Enter(sender As Object, e As EventArgs) Handles txtOthername.Enter
        ' ------ Placeholder Function
        If (txtOthername.Text = "Othername") Then
            txtOthername.Text = ""

            ' --- changing textcolor
            txtOthername.ForeColor = Color.Red
        End If
    End Sub

    Private Sub txtOthername_Leave(sender As Object, e As EventArgs) Handles txtOthername.Leave
        ' ----- Placeholder Function
        If (txtOthername.Text = "") Then
            txtOthername.Text = "Othername"

            ' --- changing textcolor
            txtOthername.ForeColor = Color.Black
        End If
    End Sub

    Private Sub txtDepartment_Enter(sender As Object, e As EventArgs) Handles txtDepartment.Enter
        ' ------ Placeholder Function
        If (txtDepartment.Text = "Department") Then
            txtDepartment.Text = ""

            ' --- changing textcolor
            txtDepartment.ForeColor = Color.Red
        End If
    End Sub

    Private Sub txtDepartment_Leave(sender As Object, e As EventArgs) Handles txtDepartment.Leave
        ' ------  Placeholder Function
        If (txtDepartment.Text = "") Then
            txtDepartment.Text = "Department"

            ' --- changing textcolor
            txtDepartment.ForeColor = Color.Black
        End If
    End Sub

    Private Sub txtGender_Enter(sender As Object, e As EventArgs) Handles txtGender.Enter
        ' ------ Placeholder Function
        If (txtGender.Text = "Gender") Then
            txtGender.Text = ""

            ' --- changing textcolor
            txtGender.ForeColor = Color.Red
        End If
    End Sub

    Private Sub txtGender_Leave(sender As Object, e As EventArgs) Handles txtGender.Leave
        ' ------ Placeholder Function
        If (txtGender.Text = "") Then
            txtGender.Text = "Gender"

            ' --- changing textcolor
            txtGender.ForeColor = Color.Black
        End If
    End Sub

    Private Sub txtUsename_Enter(sender As Object, e As EventArgs) Handles txtUsename.Enter
        ' ------ Placeholder Function
        If (txtUsename.Text = "Username") Then
            txtUsename.Text = ""

            ' --- changing textcolor
            txtUsename.ForeColor = Color.Red
        End If
    End Sub

    Private Sub txtUsename_Leave(sender As Object, e As EventArgs) Handles txtUsename.Leave
        ' ------ Placeholder Function
        If (txtUsename.Text = "") Then
            txtUsename.Text = "Username"

            ' --- changing textcolor
            txtUsename.ForeColor = Color.Black
        End If
    End Sub

    Private Sub txtPassword_Enter(sender As Object, e As EventArgs) Handles txtPassword.Enter
        ' ------ Placeholder Function
        If (txtPassword.Text = "Password") Then
            txtPassword.Text = ""

            ' --- changing textcolor
            txtPassword.ForeColor = Color.Red
        End If
    End Sub

    Private Sub txtPassword_Leave(sender As Object, e As EventArgs) Handles txtPassword.Leave
        ' ------ Placeholder Function
        If (txtPassword.Text = "") Then
            txtPassword.Text = "Password"

            ' --- changing textcolor
            txtPassword.ForeColor = Color.Black
        End If
    End Sub

    Private Sub txtTelephone_Enter(sender As Object, e As EventArgs) Handles txtTelephone.Enter
        ' ------ Placeholder Function
        If (txtTelephone.Text = "Telephone") Then
            txtTelephone.Text = ""

            ' --- changing textcolor
            txtTelephone.ForeColor = Color.Red
        End If
    End Sub

    Private Sub txtTelephone_Leave(sender As Object, e As EventArgs) Handles txtTelephone.Leave
        ' ------ Placeholder Function
        If (txtTelephone.Text = "") Then
            txtTelephone.Text = "Telephone"

            txtTelephone.ForeColor = Color.Black
        End If
    End Sub

    Private Sub Create_Instructor_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        ' ------ Hiding form component
        SearchComboBox.Visible = False
        btnSearch.Visible = False
        btnUpdate.Visible = False
    End Sub

    Private Sub btnEdit_Click(sender As Object, e As EventArgs) Handles btnEdit.Click
        ' ------ Showing elements
        SearchComboBox.Visible = True
        btnSearch.Visible = True
        btnUpdate.Visible = True

    End Sub

    Private Sub btnSave_Click(sender As Object, e As EventArgs) Handles btnSave.Click
        ' ------ checking if textboxes and image box contains values
        If Not String.IsNullOrEmpty(txtFirstname.Text) AndAlso
           Not String.IsNullOrEmpty(txtLastname.Text) AndAlso
           Not String.IsNullOrEmpty(txtOthername.Text) AndAlso
           Not String.IsNullOrEmpty(txtDepartment.Text) AndAlso
           Not String.IsNullOrEmpty(txtGender.Text) AndAlso
           Not String.IsNullOrEmpty(txtUsename.Text) AndAlso
           Not String.IsNullOrEmpty(txtPassword.Text) AndAlso
           Not String.IsNullOrEmpty(txtTelephone.Text) AndAlso
           UserPictureBox.Image IsNot Nothing Then

            ' 

        End If
    End Sub
End Class