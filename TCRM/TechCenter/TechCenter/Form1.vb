'Importing Sql Library Modulo
Imports System.Data.SqlClient    ' ------- Allowing us to use sql 
Public Class Form1
    'Database Connection String 
    Dim con = New SqlConnection("Data Source=ROACH\SQL;Initial Catalog=IPMC_Management;Integrated Security=SSPI")

    ' ---- Creating a user-defined function
    Private Sub ResettingData()
        ' -- Resetting Textboxes
        txtUsername.Text = "Username"
        txtPassword.Text = "Password"
        txtPassword.isPassword = False

        ' Changing Active control
        Me.ActiveControl = lblDateTime

    End Sub

    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        ' ------ creating a responsive layout screen
        Me.WindowState = FormWindowState.Maximized
        ' ------ Screen responsive variables
        Dim Height As Integer = Screen.PrimaryScreen.WorkingArea.Height
        Dim Width As Integer = Screen.PrimaryScreen.WorkingArea.Width
        ' ------ Setting new screen variable
        Me.ClientSize = New Size(Height, Width)

        ' ------ Setting active control
        Me.ActiveControl = lblDateTime

        ' ------ Setting datetime_Timer to update every second
        datetime_Timer.Interval = 1000
        ' --- Starting Timer
        datetime_Timer.Start()

        ' ----- Hiding the Eye buttons
        btnShow.Visible = False
        btnHide.Visible = False
    End Sub

    Private Sub btnMinimize_Click(sender As Object, e As EventArgs) Handles btnMinimize.Click
        ' ------ Minimizing function
        Me.WindowState = FormWindowState.Minimized
    End Sub

    Private Sub btnClose_Click(sender As Object, e As EventArgs) Handles btnClose.Click
        ' ------ Close function
        Dim closeWindow As DialogResult = MessageBox.Show _
            ("Are you sure you want to exit the application", "EXIT",
                    MessageBoxButtons.YesNo, MessageBoxIcon.Information,
                        MessageBoxDefaultButton.Button1)
        ' ------ close if user clicks yes
        If closeWindow = DialogResult.Yes Then
            Application.Exit()
        End If
    End Sub

    Private Sub datetime_Timer_Tick(sender As Object, e As EventArgs) Handles datetime_Timer.Tick
        ' ------ Getting current system date & time
        Dim currentDateTime As DateTime = DateTime.Now
        Dim FormatedDateTime As String = currentDateTime.ToString("MMMM dd, yyyy - HH:mm:ss")

        ' ----- Assigning Formatted value to label
        lblDateTime.Text = FormatedDateTime
    End Sub

    Private Sub txtUsername_Enter(sender As Object, e As EventArgs) Handles txtUsername.Enter
        ' ------ Username placeholder function
        If (txtUsername.Text = "Username") Then
            txtUsername.Text = ""

            ' --- Changing TextColor
            txtUsername.ForeColor = Color.Red
        End If

    End Sub

    Private Sub txtUsername_Leave(sender As Object, e As EventArgs) Handles txtUsername.Leave
        ' ------ Username placeholder function
        If (txtUsername.Text = "") Then
            txtUsername.Text = "Username"

            ' --- Changing TextColor
            txtUsername.ForeColor = Color.Black
        End If
    End Sub

    Private Sub txtPassword_Enter(sender As Object, e As EventArgs) Handles txtPassword.Enter
        ' ------ Password placeholder function
        If (txtPassword.Text = "Password") Then
            txtPassword.Text = ""

            ' --- Setting isPassword Property
            txtPassword.isPassword = True

            ' --- Changing TextColor
            txtPassword.ForeColor = Color.Red
        End If
    End Sub

    Private Sub txtPassword_Leave(sender As Object, e As EventArgs) Handles txtPassword.Leave
        ' ------ Password placeholder function
        If (txtPassword.Text = "") Then
            txtPassword.Text = "Password"

            ' --- Removing isPassword Property
            txtPassword.isPassword = False

            ' --- Changing TextColor
            txtPassword.ForeColor = Color.Black

            ' Hiding all eye button
            btnShow.Visible = False
            btnHide.Visible = False
        End If
    End Sub

    Private Sub btnShow_Click(sender As Object, e As EventArgs) Handles btnShow.Click
        ' ------ Showing Password text
        txtPassword.isPassword = False
        ' --- Hiding show button
        btnShow.Visible = False
        ' -- Showing hide button
        btnHide.Visible = True
        ' - changing textcolor
        txtPassword.ForeColor = Color.Black
    End Sub

    Private Sub btnHide_Click(sender As Object, e As EventArgs) Handles btnHide.Click
        ' ------ Hiding Password text
        txtPassword.isPassword = True
        ' --- Hiding hide button
        btnHide.Visible = False
        ' -- Showing show button
        btnShow.Visible = True
        ' - changing textcolor
        txtPassword.ForeColor = Color.Red
    End Sub

    Private Sub txtPassword_KeyUp(sender As Object, e As KeyEventArgs) Handles txtPassword.KeyUp
        ' ------ showing Eye button
        btnShow.Visible = True
    End Sub


    Private Sub btnLogin_Click(sender As Object, e As EventArgs) Handles btnLogin.Click
        ' ------ Setting up all users login function
        If txtUsername.Text IsNot "" Then
            ' ---- Admin Login Statement
            Dim admin_cmd As New SqlCommand("SELECT * FROM Admin WHERE 
                                           (Username = '" & txtUsername.Text & "')
                                        AND(Password = '" & txtPassword.Text & "')", con)

            ' ---- Instructor's Login Statement
            Dim instruct_cmd As New SqlCommand("SELECT * FROM Instructor WHERE 
                                              (Username = '" & txtUsername.Text & "')
                                           AND(Password = '" & txtPassword.Text & "')", con)

            ' ---- Student Login Statement
            Dim student_cmd As New SqlCommand("SELECT * FROM Student WHERE 
                                             (Username = '" & txtUsername.Text & "')
                                          AND(Password = '" & txtPassword.Text & "')", con)

            ' ---- Opening Connection To Database
            con.Open()
            ' ------ Setting up Database to pickup Data
            ' ---- Setting up admin sql reader
            Dim admin_sdr As SqlDataReader = admin_cmd.ExecuteReader()
            Dim final_admin_sdr = admin_sdr.Read()
            admin_sdr.Close()

            ' ---- Setting up instructor sql reader
            Dim instruct_sdr As SqlDataReader = instruct_cmd.ExecuteReader()
            Dim final_instruct_sdr = instruct_sdr.Read()
            instruct_sdr.Close()

            ' ---- Setting up stuent sql reader
            Dim student_sdr As SqlDataReader = student_cmd.ExecuteReader()
            Dim final_student_sdr = student_sdr.Read()
            student_sdr.Close()

            ' ---- Validating Reading Result for  Admin
            If (final_admin_sdr = True) Then
                MessageBox.Show("Admin Authentication Validated",
                                "ADMIN LOGIN", MessageBoxButtons.OK,
                                    MessageBoxIcon.Information)
                ' -- Page Navigation to Admin Dashboard
                Me.Hide()
                AdminDashboard.Show()

                ' -- Calling function
                ResettingData()

            ElseIf (final_instruct_sdr = True) Then
                ' ---- Validating Reading Result for Instructor
                MessageBox.Show("Instructor Authentication Validation",
                                "INSTRUCTOR LOGIN", MessageBoxButtons.OK,
                                    MessageBoxIcon.Information)

                ' -- Page Naviagation to Instructor Dashboard
                Me.Hide()
                InstructorDashboard.Show()

                ' -- Calling function
                ResettingData()

            ElseIf (final_student_sdr = True) Then
                ' ---- Validating Reading Result for Student
                MessageBox.Show("Student Authentication Validated",
                                "STUDENT LOGIN", MessageBoxButtons.OK,
                                    MessageBoxIcon.Information)

                ' -- Page Navigation to Student Dashbaord
                Me.Hide()
                Student_Dashboard.Show()

                ' -- Calling Function
                ResettingData()

            Else
                ' ---- No Data was able to be collected
                MessageBox.Show("Invalid Username Or Password",
                                "LOGIN ERROR", MessageBoxButtons.OK,
                                    MessageBoxIcon.Information)
                'Focusing On Textboxes
                txtUsername.BorderColorIdle = Color.Red
                txtPassword.BorderColorFocused = Color.Red

            End If
        End If
        ' ------ Closing Connection To Database
        con.Close()
    End Sub


End Class
