namespace gymfit_app.uc
{
	partial class uc_mensalidades
	{
		/// <summary> 
		/// Required designer variable.
		/// </summary>
		private System.ComponentModel.IContainer components = null;

		/// <summary> 
		/// Clean up any resources being used.
		/// </summary>
		/// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
		protected override void Dispose(bool disposing)
		{
			if (disposing && (components != null))
			{
				components.Dispose();
			}
			base.Dispose(disposing);
		}

		#region Component Designer generated code

		/// <summary> 
		/// Required method for Designer support - do not modify 
		/// the contents of this method with the code editor.
		/// </summary>
		private void InitializeComponent()
		{
			System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle1 = new System.Windows.Forms.DataGridViewCellStyle();
			System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle2 = new System.Windows.Forms.DataGridViewCellStyle();
			System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle3 = new System.Windows.Forms.DataGridViewCellStyle();
			System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle4 = new System.Windows.Forms.DataGridViewCellStyle();
			this.btn_search = new System.Windows.Forms.Button();
			this.txt_search = new System.Windows.Forms.TextBox();
			this.pic_refresh = new System.Windows.Forms.PictureBox();
			this.dgv_mensalidades = new System.Windows.Forms.DataGridView();
			this.client_name = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.mensalidade = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.desconto = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.total_pagar = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.estado = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.mes = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.data_pagamento = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.btn_pagar = new System.Windows.Forms.Button();
			this.label1 = new System.Windows.Forms.Label();
			this.btn_proximo = new System.Windows.Forms.Button();
			this.btn_anterior = new System.Windows.Forms.Button();
			this.btn_cancelar = new System.Windows.Forms.Button();
			this.panel8 = new System.Windows.Forms.Panel();
			((System.ComponentModel.ISupportInitialize)(this.pic_refresh)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.dgv_mensalidades)).BeginInit();
			this.panel8.SuspendLayout();
			this.SuspendLayout();
			// 
			// btn_search
			// 
			this.btn_search.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this.btn_search.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_search.FlatAppearance.BorderSize = 0;
			this.btn_search.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_search.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_search.ForeColor = System.Drawing.Color.White;
			this.btn_search.Location = new System.Drawing.Point(651, 24);
			this.btn_search.Name = "btn_search";
			this.btn_search.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_search.Size = new System.Drawing.Size(112, 27);
			this.btn_search.TabIndex = 27;
			this.btn_search.Text = "Pesquisar";
			this.btn_search.TextAlign = System.Drawing.ContentAlignment.TopLeft;
			this.btn_search.UseVisualStyleBackColor = true;
			// 
			// txt_search
			// 
			this.txt_search.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this.txt_search.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.txt_search.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.txt_search.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.txt_search.ForeColor = System.Drawing.Color.WhiteSmoke;
			this.txt_search.Location = new System.Drawing.Point(445, 24);
			this.txt_search.Name = "txt_search";
			this.txt_search.Size = new System.Drawing.Size(200, 27);
			this.txt_search.TabIndex = 26;
			// 
			// pic_refresh
			// 
			this.pic_refresh.Cursor = System.Windows.Forms.Cursors.Hand;
			this.pic_refresh.Image = global::gymfit_app.Properties.Resources.refresh;
			this.pic_refresh.Location = new System.Drawing.Point(30, 21);
			this.pic_refresh.Name = "pic_refresh";
			this.pic_refresh.Size = new System.Drawing.Size(29, 25);
			this.pic_refresh.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this.pic_refresh.TabIndex = 28;
			this.pic_refresh.TabStop = false;
			this.pic_refresh.Click += new System.EventHandler(this.pic_refresh_Click);
			// 
			// dgv_mensalidades
			// 
			this.dgv_mensalidades.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.dgv_mensalidades.AutoSizeColumnsMode = System.Windows.Forms.DataGridViewAutoSizeColumnsMode.Fill;
			dataGridViewCellStyle1.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
			dataGridViewCellStyle1.BackColor = System.Drawing.SystemColors.Control;
			dataGridViewCellStyle1.Font = new System.Drawing.Font("Century Gothic", 12F);
			dataGridViewCellStyle1.ForeColor = System.Drawing.SystemColors.WindowText;
			dataGridViewCellStyle1.SelectionBackColor = System.Drawing.SystemColors.Highlight;
			dataGridViewCellStyle1.SelectionForeColor = System.Drawing.SystemColors.HighlightText;
			dataGridViewCellStyle1.WrapMode = System.Windows.Forms.DataGridViewTriState.True;
			this.dgv_mensalidades.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
			this.dgv_mensalidades.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
			this.dgv_mensalidades.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.client_name,
            this.mensalidade,
            this.desconto,
            this.total_pagar,
            this.estado,
            this.mes,
            this.data_pagamento});
			dataGridViewCellStyle2.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
			dataGridViewCellStyle2.BackColor = System.Drawing.SystemColors.Window;
			dataGridViewCellStyle2.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			dataGridViewCellStyle2.ForeColor = System.Drawing.SystemColors.ControlText;
			dataGridViewCellStyle2.SelectionBackColor = System.Drawing.SystemColors.Highlight;
			dataGridViewCellStyle2.SelectionForeColor = System.Drawing.SystemColors.HighlightText;
			dataGridViewCellStyle2.WrapMode = System.Windows.Forms.DataGridViewTriState.False;
			this.dgv_mensalidades.DefaultCellStyle = dataGridViewCellStyle2;
			this.dgv_mensalidades.Location = new System.Drawing.Point(5, 5);
			this.dgv_mensalidades.Name = "dgv_mensalidades";
			dataGridViewCellStyle3.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
			dataGridViewCellStyle3.BackColor = System.Drawing.SystemColors.Control;
			dataGridViewCellStyle3.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			dataGridViewCellStyle3.ForeColor = System.Drawing.SystemColors.WindowText;
			dataGridViewCellStyle3.SelectionBackColor = System.Drawing.SystemColors.Highlight;
			dataGridViewCellStyle3.SelectionForeColor = System.Drawing.SystemColors.HighlightText;
			dataGridViewCellStyle3.WrapMode = System.Windows.Forms.DataGridViewTriState.True;
			this.dgv_mensalidades.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
			this.dgv_mensalidades.RowHeadersWidthSizeMode = System.Windows.Forms.DataGridViewRowHeadersWidthSizeMode.AutoSizeToAllHeaders;
			dataGridViewCellStyle4.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.dgv_mensalidades.RowsDefaultCellStyle = dataGridViewCellStyle4;
			this.dgv_mensalidades.RowTemplate.Height = 40;
			this.dgv_mensalidades.Size = new System.Drawing.Size(722, 392);
			this.dgv_mensalidades.TabIndex = 29;
			// 
			// client_name
			// 
			this.client_name.FillWeight = 76.52276F;
			this.client_name.HeaderText = "Nome";
			this.client_name.MinimumWidth = 120;
			this.client_name.Name = "client_name";
			// 
			// mensalidade
			// 
			this.mensalidade.FillWeight = 43.95851F;
			this.mensalidade.HeaderText = "Mensalidade";
			this.mensalidade.Name = "mensalidade";
			// 
			// desconto
			// 
			this.desconto.FillWeight = 43.95851F;
			this.desconto.HeaderText = "Desconto";
			this.desconto.Name = "desconto";
			// 
			// total_pagar
			// 
			this.total_pagar.FillWeight = 43.95851F;
			this.total_pagar.HeaderText = "Total a pagar";
			this.total_pagar.Name = "total_pagar";
			// 
			// estado
			// 
			this.estado.FillWeight = 43.95851F;
			this.estado.HeaderText = "Estado";
			this.estado.Name = "estado";
			// 
			// mes
			// 
			this.mes.FillWeight = 40F;
			this.mes.HeaderText = "Mês";
			this.mes.Name = "mes";
			// 
			// data_pagamento
			// 
			this.data_pagamento.FillWeight = 43.95851F;
			this.data_pagamento.HeaderText = "Data pagamento";
			this.data_pagamento.Name = "data_pagamento";
			// 
			// btn_pagar
			// 
			this.btn_pagar.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this.btn_pagar.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_pagar.FlatAppearance.BorderSize = 0;
			this.btn_pagar.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_pagar.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_pagar.ForeColor = System.Drawing.Color.White;
			this.btn_pagar.Location = new System.Drawing.Point(351, 19);
			this.btn_pagar.Name = "btn_pagar";
			this.btn_pagar.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_pagar.Size = new System.Drawing.Size(88, 34);
			this.btn_pagar.TabIndex = 30;
			this.btn_pagar.Text = "Pagar";
			this.btn_pagar.UseVisualStyleBackColor = true;
			this.btn_pagar.Click += new System.EventHandler(this.btn_pagar_Click);
			// 
			// label1
			// 
			this.label1.Anchor = System.Windows.Forms.AnchorStyles.Bottom;
			this.label1.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.label1.ForeColor = System.Drawing.Color.White;
			this.label1.Location = new System.Drawing.Point(129, 478);
			this.label1.Name = "label1";
			this.label1.Size = new System.Drawing.Size(535, 23);
			this.label1.TabIndex = 31;
			this.label1.Text = "1 de 10";
			this.label1.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
			// 
			// btn_proximo
			// 
			this.btn_proximo.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this.btn_proximo.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_proximo.FlatAppearance.BorderSize = 0;
			this.btn_proximo.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_proximo.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_proximo.ForeColor = System.Drawing.Color.White;
			this.btn_proximo.Location = new System.Drawing.Point(670, 476);
			this.btn_proximo.Name = "btn_proximo";
			this.btn_proximo.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_proximo.Size = new System.Drawing.Size(93, 27);
			this.btn_proximo.TabIndex = 32;
			this.btn_proximo.Text = "Próximo";
			this.btn_proximo.UseVisualStyleBackColor = true;
			// 
			// btn_anterior
			// 
			this.btn_anterior.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this.btn_anterior.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_anterior.FlatAppearance.BorderSize = 0;
			this.btn_anterior.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_anterior.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_anterior.ForeColor = System.Drawing.Color.White;
			this.btn_anterior.Location = new System.Drawing.Point(30, 476);
			this.btn_anterior.Name = "btn_anterior";
			this.btn_anterior.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_anterior.Size = new System.Drawing.Size(93, 27);
			this.btn_anterior.TabIndex = 33;
			this.btn_anterior.Text = "Anterior";
			this.btn_anterior.UseVisualStyleBackColor = true;
			// 
			// btn_cancelar
			// 
			this.btn_cancelar.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this.btn_cancelar.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_cancelar.FlatAppearance.BorderSize = 0;
			this.btn_cancelar.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_cancelar.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_cancelar.ForeColor = System.Drawing.Color.White;
			this.btn_cancelar.Location = new System.Drawing.Point(248, 19);
			this.btn_cancelar.Name = "btn_cancelar";
			this.btn_cancelar.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_cancelar.Size = new System.Drawing.Size(97, 34);
			this.btn_cancelar.TabIndex = 34;
			this.btn_cancelar.Text = "Cancelar";
			this.btn_cancelar.UseVisualStyleBackColor = true;
			// 
			// panel8
			// 
			this.panel8.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.panel8.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(32)))), ((int)(((byte)(32)))), ((int)(((byte)(32)))));
			this.panel8.Controls.Add(this.dgv_mensalidades);
			this.panel8.Location = new System.Drawing.Point(30, 67);
			this.panel8.Name = "panel8";
			this.panel8.Size = new System.Drawing.Size(733, 403);
			this.panel8.TabIndex = 35;
			// 
			// uc_mensalidades
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.Controls.Add(this.btn_cancelar);
			this.Controls.Add(this.btn_anterior);
			this.Controls.Add(this.btn_proximo);
			this.Controls.Add(this.label1);
			this.Controls.Add(this.btn_pagar);
			this.Controls.Add(this.pic_refresh);
			this.Controls.Add(this.btn_search);
			this.Controls.Add(this.txt_search);
			this.Controls.Add(this.panel8);
			this.Name = "uc_mensalidades";
			this.Size = new System.Drawing.Size(792, 511);
			this.Load += new System.EventHandler(this.uc_mensalidades_Load);
			((System.ComponentModel.ISupportInitialize)(this.pic_refresh)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.dgv_mensalidades)).EndInit();
			this.panel8.ResumeLayout(false);
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.PictureBox pic_refresh;
		private System.Windows.Forms.Button btn_search;
		private System.Windows.Forms.TextBox txt_search;
		private System.Windows.Forms.DataGridView dgv_mensalidades;
		private System.Windows.Forms.Button btn_pagar;
		private System.Windows.Forms.Label label1;
		private System.Windows.Forms.Button btn_proximo;
		private System.Windows.Forms.Button btn_anterior;
		private System.Windows.Forms.Button btn_cancelar;
		private System.Windows.Forms.DataGridViewTextBoxColumn client_name;
		private System.Windows.Forms.DataGridViewTextBoxColumn mensalidade;
		private System.Windows.Forms.DataGridViewTextBoxColumn desconto;
		private System.Windows.Forms.DataGridViewTextBoxColumn total_pagar;
		private System.Windows.Forms.DataGridViewTextBoxColumn estado;
		private System.Windows.Forms.DataGridViewTextBoxColumn mes;
		private System.Windows.Forms.DataGridViewTextBoxColumn data_pagamento;
		private System.Windows.Forms.Panel panel8;
	}
}
