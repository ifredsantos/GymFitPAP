using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Forms;
using MySql.Data;
using MySql.Data.MySqlClient;

namespace gymfit_app
{
	public partial class FormLogin : Form
	{
		public FormLogin()
		{
			InitializeComponent();
		}

		private void btn_login_Click(object sender, EventArgs e)
		{
			DateTime current_date = DateTime.Now;


			string user, psw;

			user = txt_username_email.Text;
			psw = config.getMD5Hash(txt_psw.Text);

			if (user == "" || psw == "") return;

			MySqlConnection Conn;
			MySqlCommand Cmd;
			MySqlDataReader Dr;

			Conn = new MySqlConnection(config.conn_string);

			try
			{
				Conn.Open();
				Cmd = new MySqlCommand("SELECT cod_utilizador, username, tipo_utilizador FROM utilizadores WHERE username = @user AND psw = @psw" +
					" OR email = @user AND psw = @psw", Conn);

				Cmd.Parameters.AddWithValue("@user", user);
				Cmd.Parameters.AddWithValue("@psw", psw);

				Cmd.ExecuteNonQuery();
				Dr = Cmd.ExecuteReader();

				if (Dr.HasRows)
				{
					if (Dr.Read())
					{
						config.utilizador = new cl_utilizador()
						{
							cod_user = Dr["cod_utilizador"].ToString(),
							username = Dr["username"].ToString(),
							tipo_user = Dr["tipo_utilizador"].ToString()
						};

						int cod_user = Convert.ToInt32(Dr["cod_utilizador"]);
						Cmd.Dispose();

						try
						{
							Cmd = new MySqlCommand("UPDATE utilizadores SET data_ultimoAcesso = @date WHERE cod_utilizador = @user", Conn);

							Cmd.Parameters.AddWithValue("@date", current_date);
							Cmd.Parameters.AddWithValue("@user", cod_user);
							Cmd.ExecuteNonQuery();

							Cmd.Dispose();
						}
						catch
						{
							MessageBox.Show("Não foi possivel atualizar a ultima data de acesso", "Erro de acesso", MessageBoxButtons.OK, MessageBoxIcon.Error);
						}

						MainForm formMain = new MainForm();
						formMain.Hide();

						timer1.Enabled = true;
					}
				}
				else
				{
					DialogResult dialogResult = MessageBox.Show("Dados de login incorretos!\nDeseja tentar novamente?", "Dados de login", MessageBoxButtons.RetryCancel, MessageBoxIcon.Warning);
					if (dialogResult == DialogResult.Cancel)
					{
						Application.Exit();
					}
				}
			}
			catch (Exception ex)
			{
				MessageBox.Show("Ocorreu um erro de ligação à base de dados\n" + ex, "Ligação à base de dados", MessageBoxButtons.OK, MessageBoxIcon.Error);
			}
			finally
			{
				Conn.Close();
			}
		}

		private void pic_close_Click(object sender, EventArgs e)
		{
			Application.Exit();
		}

		private void pic_min_Click(object sender, EventArgs e)
		{
			this.WindowState = FormWindowState.Minimized;
		}

        private void FormLogin_Load(object sender, EventArgs e)
        {
            circulaPB_formMainLoading.Value = 0;
            circulaPB_formMainLoading.Minimum = 0;
            circulaPB_formMainLoading.Maximum = 50;
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            if(circulaPB_formMainLoading.Value < 50)
            {
                circulaPB_formMainLoading.Value = circulaPB_formMainLoading.Value + 5;
            }
            else
            {
                timer1.Enabled = false;
                MainForm formMain = new MainForm();
                formMain.Show();
                this.Hide();
            }
        }
    }
}