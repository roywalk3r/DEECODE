Public Class AdminDashboard
    Private Sub AdminDashboard_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        ' ------ Creating Responsive layout screen
        Me.WindowState = FormWindowState.Maximized

        ' ---- Form Responsive variable
        Dim Height As Integer = Screen.PrimaryScreen.WorkingArea.Height
        Dim Width As Integer = Screen.PrimaryScreen.WorkingArea.Width

        ' -- Form New Size
        Me.ClientSize = New Size(Height, Width)


        ' ------ Setting datetime_Timer to update every second
        datetime_Timer.Interval = 1000
        ' --- Starting Timer
        datetime_Timer.Start()

        ' ---- Passing textbox value to label
        lblUsername.Text = Form1.txtUsername.Text
    End Sub

    Private Sub datetime_Timer_Tick(sender As Object, e As EventArgs) Handles datetime_Timer.Tick
        ' ------ Getting current system date & time 
        Dim currentDateTimer As DateTime = DateTime.Now
        Dim FormatedDateTime As String = currentDateTimer.ToString("MMMM dd, yyyy : HH:mm:ss")
        ' --- Assigning formatted value to label
        lblDateTime.Text = FormatedDateTime
    End Sub

    Private Sub btnMinimize_Click(sender As Object, e As EventArgs) Handles btnMinimize.Click
        ' ------ Minimize function
        Me.WindowState = FormWindowState.Minimized
    End Sub

    Private Sub btnLogout_Click(sender As Object, e As EventArgs) Handles btnLogout.Click
        ' ------ Logout function 
        Dim logout As DialogResult = MessageBox.Show _
            ("Are you sure you want to logout of this window?", "LOGOUT",
                MessageBoxButtons.YesNo, MessageBoxIcon.Information,
                    MessageBoxDefaultButton.Button1)
        If logout = DialogResult.Yes Then
            ' --- Page navigation 
            Me.Hide()
            Form1.Show()
        End If
    End Sub

    Private Sub btnCreateInstructor_Click(sender As Object, e As EventArgs) Handles btnCreateInstructor.Click
        ' ------ Clearing all control from the panel
        formLoadingPanel.Controls.Clear()

        ' ---- Loading Create Instructors Page
        Create_Instructor.TopLevel = False
        Me.formLoadingPanel.Controls.Add(Create_Instructor)
        ' -- Showing Create Instructor page
        Create_Instructor.Show()
    End Sub

    Private Sub btnCreateStudent_Click(sender As Object, e As EventArgs) Handles btnCreateStudent.Click
        ' ------ Clearing all control from the panel
        formLoadingPanel.Controls.Clear()

        ' ---- Loading Create Instructors Page
        Create_Student.TopLevel = False
        Me.formLoadingPanel.Controls.Add(Create_Student)
        ' -- Showing Create Instructor page
        Create_Student.Show()
    End Sub

    Private Sub formLoadingPanel_Paint(sender As Object, e As PaintEventArgs) Handles formLoadingPanel.Paint

    End Sub
End Class