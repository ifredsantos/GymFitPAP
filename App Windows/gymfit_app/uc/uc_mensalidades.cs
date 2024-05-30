using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Drawing;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using MySql.Data.MySqlClient;
using System.Threading;

namespace gymfit_app.uc
{
	public partial class uc_mensalidades : UserControl
	{
		public uc_mensalidades()
		{
			InitializeComponent();
		}

		public void busca_mensalidades(string search)
		{
			dgv_mensalidades.Rows.Clear();

			MySqlConnection Conn;
			MySqlCommand Cmd;
			MySqlDataReader Dr;

			Conn = new MySqlConnection(config.conn_string);

			/* ====================================================================
             * BUSCA MENSALIDADES
             * ====================================================================
             */
			try
			{
				Conn.Open();

				Cmd = new MySqlCommand("SELECT MP.cod_mensalidadePagamento, U.cod_utilizador, U.nome, M.nome_mensalidade, M.preco," +
					" D.nome_desconto, D.valor_desconto, MP.valor_pago, MP.mes, MP.ano, MP.data_pagamento, MP.cancelado " +
					"FROM mensalidades_pagamentos MP " +
						"INNER JOIN mensalidades_aquisicoes MAQ ON MP.aquisicao = MAQ.cod_aquisicao " +
						"INNER JOIN mensalidades M ON MAQ.mensalidade = M.cod_mensalidade " +
						"INNER JOIN mensalidades_descontos D ON MAQ.desconto = D.cod_desconto " +
						"INNER JOIN utilizadores U ON U.cod_utilizador = MP.cod_utilizador " +
					"WHERE MAQ.atual LIKE 's' @pesqisa " +
					"ORDER BY MP.mes DESC, MP.ano DESC, U.nome " +
					"LIMIT @inicio, @quantidade", Conn);

				Cmd.Parameters.AddWithValue("@pesqisa", "");
				Cmd.Parameters.AddWithValue("@inicio", 0);
				Cmd.Parameters.AddWithValue("@quantidade", 10);

				Dr = Cmd.ExecuteReader();
				
				if (Dr.HasRows)
				{
					DateTime data_atual = DateTime.Now;
					string dia_pagamento = config.dia_pagamento;
					int n_linhas = 0;

					while (Dr.Read())
					{
						int cod_user = Convert.ToInt32(Dr["cod_utilizador"].ToString());
						string nome = Dr["nome"].ToString();
						double total_pagar = Convert.ToDouble(Dr["preco"]) - Convert.ToDouble(Dr["valor_desconto"]);
						string status;
						int mes = Convert.ToInt32(Dr["mes"].ToString());
						int ano = Convert.ToInt32(Dr["ano"].ToString());
						string data_pagamento = Dr["data_pagamento"].ToString();
						string nome_mensalidade = Dr["nome_mensalidade"].ToString();
						string nome_desconto = Dr["nome_desconto"].ToString();
						string cancelado = Dr["cancelado"].ToString();
						double valor_pago;
						DateTime date_data_pagamento;
						DateTime dataLimitePagamento = Convert.ToDateTime(dia_pagamento + "/" + mes + "/" + ano);

						if (data_pagamento != "")
						{
							date_data_pagamento = Convert.ToDateTime(Dr["data_pagamento"].ToString());
							data_pagamento = date_data_pagamento.Day + "/" + date_data_pagamento.Month + "/" + date_data_pagamento.Year;
						}

						if (Dr["valor_pago"].ToString() != "")
						{
							valor_pago = Convert.ToDouble(Dr["valor_pago"]);
						}
						else
						{
							valor_pago = 0.00;
						}
						
						// Verifica seguro pago
						DateTime inicio_do_mes = Convert.ToDateTime(ano + "/" + mes + "/01");
						DateTime fim_do_mes = new DateTime(ano, mes, DateTime.DaysInMonth(ano, mes));
						DateTime data_pagamento_seguro = Convert.ToDateTime("01/01/0001");

						MySqlConnection ConnSeg;
						MySqlCommand CmdSeg;
						MySqlDataReader DrSeg;
						ConnSeg = new MySqlConnection(config.conn_string);

						try
						{
							ConnSeg.Open();
							CmdSeg = new MySqlCommand("SELECT data_pagamento FROM seguros WHERE utilizador = @cod_user AND ano = @ano", ConnSeg);
							CmdSeg.Parameters.AddWithValue("@cod_user", cod_user);
							CmdSeg.Parameters.AddWithValue("@ano", ano);

							DrSeg = CmdSeg.ExecuteReader();

							if (DrSeg.HasRows)
							{
								if (DrSeg.Read())
								{
									if (DrSeg["data_pagamento"].ToString() != "")
									{
										data_pagamento_seguro = Convert.ToDateTime(DrSeg["data_pagamento"].ToString());
									}
									else
									{
										data_pagamento_seguro = Convert.ToDateTime("01/01/2001");
									}
								}
							}
							else
							{
								data_pagamento_seguro = Convert.ToDateTime("01/01/0001");
							}

							//CmdSeg.Dispose();
							//DrSeg.Dispose();
						}
						catch
						{
							MessageBox.Show("Não foi possivel verificar o seguro do utilizador: " + nome, "Erro na consulta", MessageBoxButtons.OK, MessageBoxIcon.Error);
						}
						// =========================================================
						

						// Verifica estado da mensalidade
						// Estado pago
						if (cancelado == "n" && data_pagamento != "")
						{
							status = "Pago";
							total_pagar = valor_pago;
						}
						// Estado por pagar
						else if (cancelado == "n" && data_pagamento == "" && data_atual > dataLimitePagamento)
						{
							status = "Por pagar";
							data_pagamento = "-";
						}
						else
						{
							status = "Cancelado";
							data_pagamento = data_atual.ToString();
						}

						if (data_pagamento_seguro != Convert.ToDateTime("01/01/0001"))
						{
							nome_mensalidade = nome_mensalidade + " + Seguro";
							total_pagar = total_pagar + Convert.ToDouble(config.dia_pagamento);
						}

						dgv_mensalidades.Rows.Add(
							nome,
							nome_mensalidade,
							nome_desconto,
							total_pagar.ToString() + "€",
							status,
							mes + "/" + ano.ToString(),
							data_pagamento
						);

						if (dgv_mensalidades.Rows[n_linhas].Cells["estado"].Value.ToString() == "Por pagar")
						{
							dgv_mensalidades.Rows[n_linhas].Cells["estado"].Style.ForeColor = Color.Red;
						}
						else if (dgv_mensalidades.Rows[n_linhas].Cells["estado"].Value.ToString() == "Cancelado")
						{
							dgv_mensalidades.Rows[n_linhas].Cells["estado"].Style.ForeColor = Color.Orange;
						}

						n_linhas++;
					}
					/*Dr.Dispose();
					Cmd.Dispose();*/
				}
				else
				{
					MessageBox.Show("Não foi encontrado nenhum registo", "Sem registos", MessageBoxButtons.OK, MessageBoxIcon.Error);
				}

				Cmd.Dispose();
				Dr.Dispose();
			}
			catch (Exception ex)
			{
				MessageBox.Show("Ocorreu um erro na busca de dados à base de dados.\n"+ex, "Erro de busca", MessageBoxButtons.OK, MessageBoxIcon.Warning);
			}
			finally
			{
				if (Conn.State == ConnectionState.Open)
				{
					Conn.Close();
				}

				Conn.Dispose();
			}
		}

		private void uc_mensalidades_Load(object sender, EventArgs e)
		{
			busca_mensalidades("");
		}

		private void btn_pagar_Click(object sender, EventArgs e)
		{
		}

		private void pic_refresh_Click(object sender, EventArgs e)
		{
			busca_mensalidades("");

			Thread.Sleep(1000);
			MessageBox.Show("Dados atualizados com sucesso", "Dados atualizados", MessageBoxButtons.OK, MessageBoxIcon.Information);
		}
	}
}
