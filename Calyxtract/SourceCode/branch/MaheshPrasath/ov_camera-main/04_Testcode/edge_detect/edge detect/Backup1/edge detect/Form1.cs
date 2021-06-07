using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

namespace edge_detect
{
    public partial class Form1 : Form
    {
        private string _fileName = "";
        private int _proposedThresoldValue = 90;

        public Form1()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {

        }

        private void button1_Click(object sender, EventArgs e)
        {
            openFileDialog1.ShowDialog();
        }

        private void openFileDialog1_FileOk(object sender, CancelEventArgs e)
        {

            _fileName = openFileDialog1.FileName;
            pictureBox1.Image = Image.FromFile(_fileName);
        }

        private void pictureBox1_Click(object sender, EventArgs e)
        {

        }

        private void button2_Click(object sender, EventArgs e)
        {
            pictureBox2.Image = sobel(pictureBox1.Image);
        }

        public Image sobel(Image im)
        {
            int[,] gx = new int[,] { { -1, 0, 1 }, { -2, 0, 2 }, { -1, 0, 1 } };   //  The matrix Gx
            int[,] gy = new int[,] { { 1, 2, 1 }, { 0, 0, 0 }, { -1, -2, -1 } };  //  The matrix Gy
            Bitmap b = (Bitmap)im;
            Bitmap b1 = new Bitmap(im);
            for (int i = 1; i < b.Height - 1; i++)   // loop for the image pixels height
            {
                for (int j = 1; j < b.Width - 1; j++) // loop for image pixels width    
                {
                    float new_x = 0, new_y = 0;
                    float c;
                    for (int hw = -1; hw < 2; hw++)  //loop for cov matrix
                    {
                        for (int wi = -1; wi < 2; wi++)
                        {
                            c = (b.GetPixel(j + wi, i + hw).B + b.GetPixel(j + wi, i + hw).R + b.GetPixel(j + wi, i + hw).G) / 3;
                            new_x += gx[hw + 1, wi + 1] * c;
                            new_y += gy[hw + 1, wi + 1] * c;
                        }
                    }


                    if (new_x * new_x + new_y * new_y > 128 * 128)
                        b1.SetPixel(j, i, Color.Black);
                    else
                        b1.SetPixel(j, i, Color.White);
                }
            }
            return (Image)b1;
        }


        private void button5_Click(object sender, EventArgs e)
        {
            Prewitt p = new Prewitt();
            Image edgedImage;
            edgedImage = p.apply(pictureBox1.Image);
            pictureBox3.Image = edgedImage;
        }

        private void button_save_Click(object sender, EventArgs e)
        {
            saveFileDialog1.ShowDialog();
        }

        private void saveFileDialog1_FileOk(object sender, CancelEventArgs e)
        {
            /*
            save_file = saveFileDialog1.FileName;
            Bitmap b = new Bitmap(pictureBox1.Image);
            b.Save(save_file);
            */
        }


        private void button8_Click(object sender, EventArgs e)
        {
            pictureBox4.Image = ProposedEdgeDetection((Bitmap)pictureBox1.Image);
        }

        private Bitmap ProposedEdgeDetection(Bitmap b)
        {
            int n, m;
            n = b.Height;
            m = b.Width;
            int total = 0;
            Bitmap B1 = new Bitmap(m, n);

            for (int i = 0; i < m; i++)
                for (int j = 0; j < n; j++)
                {
                    B1.SetPixel(i, j, Color.White);
                }

            for (int i = 1; i < m - 1; i++)
                for (int j = 1; j < n - 1; j++)
                {


                    total = Math.Abs(b.GetPixel(i + 1, j + 1).B - b.GetPixel(i, j).B) + Math.Abs(b.GetPixel(i + 1, j + 1).R - b.GetPixel(i, j).R) + Math.Abs(b.GetPixel(i + 1, j + 1).G - b.GetPixel(i, j).G);
                    if (total > _proposedThresoldValue)
                    { B1.SetPixel(i, j, Color.Black); continue; }

                    total = Math.Abs(b.GetPixel(i, j + 1).B - b.GetPixel(i, j).B) + Math.Abs(b.GetPixel(i, j + 1).R - b.GetPixel(i, j).R) + Math.Abs(b.GetPixel(i, j + 1).G - b.GetPixel(i, j).G);
                    if (total > _proposedThresoldValue)
                    { B1.SetPixel(i, j, Color.Black); continue; }

                    total = Math.Abs(b.GetPixel(i + 1, j).B - b.GetPixel(i, j).B) + Math.Abs(b.GetPixel(i + 1, j).R - b.GetPixel(i, j).R) + Math.Abs(b.GetPixel(i + 1, j).G - b.GetPixel(i, j).G);
                    if (total > _proposedThresoldValue)
                    { B1.SetPixel(i, j, Color.Black); continue; }

                    total = Math.Abs(b.GetPixel(i - 1, j - 1).B - b.GetPixel(i, j).B) + Math.Abs(b.GetPixel(i - 1, j - 1).R - b.GetPixel(i, j).R) + Math.Abs(b.GetPixel(i - 1, j - 1).G - b.GetPixel(i, j).G);
                    if (total > _proposedThresoldValue)
                    { B1.SetPixel(i, j, Color.Black); continue; }


                    total = Math.Abs(b.GetPixel(i, j - 1).B - b.GetPixel(i, j).B) + Math.Abs(b.GetPixel(i, j - 1).R - b.GetPixel(i, j).R) + Math.Abs(b.GetPixel(i, j - 1).G - b.GetPixel(i, j).G);
                    if (total > _proposedThresoldValue)
                    { B1.SetPixel(i, j, Color.Black); continue; }

                    total = Math.Abs(b.GetPixel(i - 1, j).B - b.GetPixel(i, j).B) + Math.Abs(b.GetPixel(i - 1, j).R - b.GetPixel(i, j).R) + Math.Abs(b.GetPixel(i - 1, j).G - b.GetPixel(i, j).G);
                    if (total > _proposedThresoldValue)
                    { B1.SetPixel(i, j, Color.Black); continue; }

                    total = Math.Abs(b.GetPixel(i - 1, j + 1).B - b.GetPixel(i, j).B) + Math.Abs(b.GetPixel(i - 1, j + 1).R - b.GetPixel(i, j).R) + Math.Abs(b.GetPixel(i - 1, j + 1).G - b.GetPixel(i, j).G);
                    if (total > _proposedThresoldValue)
                    { B1.SetPixel(i, j, Color.Black); continue; }

                    total = Math.Abs(b.GetPixel(i + 1, j - 1).B - b.GetPixel(i, j).B) + Math.Abs(b.GetPixel(i + 1, j - 1).R - b.GetPixel(i, j).R) + Math.Abs(b.GetPixel(i + 1, j - 1).G - b.GetPixel(i, j).G);
                    if (total > _proposedThresoldValue)
                    { B1.SetPixel(i, j, Color.Black); continue; }

                }

            return B1;
        }

        private void button9_Click(object sender, EventArgs e)
        {
            Bitmap b = (Bitmap)black_white(pictureBox1.Image);
            pictureBox1.Image = (Image)b;
        }

        public Bitmap black_white(Image Im)
        {
            Bitmap b = (Bitmap)Im;
            int A, B, C, c;
            for (int i = 1; i < b.Height; i++)   // loop for the image pixels height
            {
                for (int j = 1; j < b.Width; j++)  // loop for the image pixels width
                {
                    Color col;
                    col = b.GetPixel(j, i);

                    A = Convert.ToInt32(col.R);
                    B = Convert.ToInt32(col.G);
                    C = Convert.ToInt32(col.B);
                    ////if(A>128||B>128||C>128)
                    if ((A > 128 && B > 128) || (A > 128 && C > 128) || (C > 128 && B > 128))
                        c = 255;
                    else
                        c = 0;

                    if (c == 0)
                        b.SetPixel(j, i, Color.Black);
                    else
                        b.SetPixel(j, i, Color.GhostWhite);

                }
            }
            return b;
        }

        private void button11_Click_1(object sender, EventArgs e)
        {
            Bitmap b = new Bitmap(pictureBox2.Image);

            pictureBox1.Image = (Image)b;
            pictureBox2.Image = (Image)black_white(pictureBox2.Image);
        }

        private void button16_Click(object sender, EventArgs e)
        {
            Bitmap b = new Bitmap(gray(pictureBox1.Image));
            pictureBox1.Image = (Image)b;
        }

        public Bitmap gray(Image Im)
        {
            Bitmap b = (Bitmap)Im;
            for (int i = 1; i < b.Height; i++)   // loop for the image pixels height
            {
                for (int j = 1; j < b.Width; j++)  // loop for the image pixels width
                {
                    Color col;
                    col = b.GetPixel(j, i);
                    b.SetPixel(j, i, Color.FromArgb((col.R + col.G + col.B) / 3, (col.R + col.G + col.B) / 3, (col.R + col.G + col.B) / 3));

                }
            }
            return b;
        }

        private void button21_Click(object sender, EventArgs e)
        {
            Bitmap b = new Bitmap(pictureBox4.Image);
            pictureBox1.Image = (Image)b;
        }

        private void button22_Click(object sender, EventArgs e)
        {
            Bitmap b = new Bitmap(pictureBox3.Image);
            pictureBox1.Image = (Image)b;
        }

        private void button3_Click(object sender, EventArgs e)
        {
            _proposedThresoldValue = Convert.ToInt16(textBox1.Text);
        }

        private void button_cmp_Click(object sender, EventArgs e)
        {
            if (checkBox_sobel.Checked && checkBox_pro.Checked)
            {
                Bitmap b1 = (Bitmap)pictureBox2.Image;
                Bitmap b2 = (Bitmap)pictureBox4.Image;
                Bitmap map = new Bitmap(pictureBox2.Image.Width, pictureBox2.Image.Height);

                for (int i = 1; i < b1.Width - 1; i++)
                    for (int j = 1; j < b1.Height - 1; j++)
                    {
                        if (b1.GetPixel(i, j).R == 0 && b2.GetPixel(i, j).R == 0)
                            map.SetPixel(i, j, Color.Black);
                        else if (b1.GetPixel(i, j).R == 0)
                            map.SetPixel(i, j, Color.Red);
                        else if (b2.GetPixel(i, j).R == 0)
                            map.SetPixel(i, j, Color.Blue);
                    }

                pictureBox5.Image = map;
            }
            else if (checkBox_prewitt.Checked && checkBox_pro.Checked)
            {
                Bitmap b1 = (Bitmap)pictureBox3.Image;
                Bitmap b2 = (Bitmap)pictureBox4.Image;
                Bitmap map = new Bitmap(pictureBox3.Image.Width, pictureBox3.Image.Height);

                for (int i = 1; i < b1.Width - 1; i++)
                    for (int j = 1; j < b1.Height - 1; j++)
                    {
                        if (b1.GetPixel(i, j).R == 0 && b2.GetPixel(i, j).R == 0)
                            map.SetPixel(i, j, Color.Black);
                        else if (b1.GetPixel(i, j).R == 0)
                            map.SetPixel(i, j, Color.Red);
                        else if (b2.GetPixel(i, j).R == 0)
                            map.SetPixel(i, j, Color.Blue);
                    }

                pictureBox5.Image = map;
            }
        }
    }
}
class Prewitt
{
    Bitmap b;
    public Image apply(Image im)
    {
        //int[,] gx = new int[,] { { -1, 0, 1 }, { -2, 0, 2 }, { -1, 0, 1 } };   //  The matrix Gx
        //int[,] gy = new int[,] { { 1, 2, 1 }, { 0, 0, 0 }, { -1, -2, -1 } };  //  The matrix Gy

        int[,] gx = new int[,] { { 1, 1, 1 }, { 0, 0, 0 }, { -1, -1, -1 } };   //  The matrix Gx
        int[,] gy = new int[,] { { -1, 0, 1 }, { -1, 0, 1 }, { -1, 0, 1 } };  //  The matrix Gy
        b = (Bitmap)im;
        Bitmap b1 = new Bitmap(b.Width, b.Height);
        for (int i = 1; i < b.Height - 1; i++)   // loop for the image pixels height
        {
            for (int j = 1; j < b.Width - 1; j++) // loop for image pixels width    
            {
                float new_x = 0, new_y = 0;
                float c;
                for (int hw = -1; hw < 2; hw++)  //loop for cov matrix
                {
                    for (int wi = -1; wi < 2; wi++)
                    {
                        c = (b.GetPixel(j + wi, i + hw).B + b.GetPixel(j + wi, i + hw).R + b.GetPixel(j + wi, i + hw).G) / 3;

                        new_x += gx[hw + 1, wi + 1] * c;
                        new_y += gy[hw + 1, wi + 1] * c;
                    }
                }
                if (new_x * new_x + new_y * new_y > 128 * 100)
                    b1.SetPixel(j, i, Color.Black);
                else
                    b1.SetPixel(j, i, Color.White);
            }
        }
        return (Image)b1;
    }
}

