Public Class Form1
    Dim OrgImage, OrgImage1, OrgImage2, GreyImage As Bitmap

    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        Close()
    End Sub

    Private Sub PictureBox1_Click(sender As Object, e As EventArgs) Handles PictureBox1.Click

    End Sub

    Private Sub PictureBoxOrginal_Click(sender As Object, e As EventArgs) Handles PictureBoxOrginal.Click

    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        OrgImage = New Bitmap(PictureBoxOrginal.Image)
        OrgImage1 = New Bitmap(PictureBoxOrginal.Image)
        OrgImage2 = New Bitmap(PictureBoxOrginal.Image)

        ' OrgImage = PictureBoxOrginal.Image
        Dim x, y As Integer
        Dim vr, vg, vb, vh As Double

        With OrgImage
            For x = 0 To .Width - 1
                For y = 0 To .Height - 1
                    vr = .GetPixel(x, y).R
                    vg = .GetPixel(x, y).G
                    vb = .GetPixel(x, y).B
                    vh = (vr + vg + vb) / 3
                    .SetPixel(x, y, Color.FromArgb(vh, vh, vh))
                Next
                PictureBoxGery.Image = OrgImage
                PictureBoxGery.Refresh()
            Next
        End With

        With OrgImage1
            For x = 0 To .Width - 1
                For y = 0 To .Height - 1
                    vr = .GetPixel(x, y).R
                    vg = .GetPixel(x, y).G
                    vb = .GetPixel(x, y).B
                    vh = ((vr * 0.2126) + (vg * 0.7152) + (vb * 0.0722))
                    .SetPixel(x, y, Color.FromArgb(vh, vh, vh))
                Next
                PictureBox1.Image = OrgImage1
                PictureBox1.Refresh()
            Next
        End With

        With OrgImage2
            For x = 0 To .Width - 1
                For y = 0 To .Height - 1
                    vr = .GetPixel(x, y).R
                    vg = .GetPixel(x, y).G
                    vb = .GetPixel(x, y).B
                    vh = ((vr * 0.2989) + (vg * 0.587) + (vb * 0.114))
                    .SetPixel(x, y, Color.FromArgb(vh, vh, vh))
                Next
                PictureBox2.Image = OrgImage2
                PictureBox2.Refresh()
            Next
        End With

    End Sub
End Class
