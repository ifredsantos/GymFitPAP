namespace gymfit_app
{
    partial class uc_mensagens
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
			this.panel8 = new System.Windows.Forms.Panel();
			this.dgv_mensagens = new System.Windows.Forms.DataGridView();
			this.Nome = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.Email = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.Mensagem = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.Data = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.Respondida = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.txt_search = new System.Windows.Forms.TextBox();
			this.btn_search = new System.Windows.Forms.Button();
			this.pic_refresh = new System.Windows.Forms.PictureBox();
			this.panel8.SuspendLayout();
			((System.ComponentModel.ISupportInitialize)(this.dgv_mensagens)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.pic_refresh)).BeginInit();
			this.SuspendLayout();
			// 
			// panel8
			// 
			this.panel8.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.panel8.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(32)))), ((int)(((byte)(32)))), ((int)(((byte)(32)))));
			this.panel8.Controls.Add(this.dgv_mensagens);
			this.panel8.Location = new System.Drawing.Point(30, 67);
			this.panel8.Name = "panel8";
			this.panel8.Size = new System.Drawing.Size(733, 416);
			this.panel8.TabIndex = 22;
			// 
			// dgv_mensagens
			// 
			this.dgv_mensagens.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.dgv_mensagens.AutoSizeColumnsMode = System.Windows.Forms.DataGridViewAutoSizeColumnsMode.Fill;
			this.dgv_mensagens.BorderStyle = System.Windows.Forms.BorderStyle.None;
			dataGridViewCellStyle1.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
			dataGridViewCellStyle1.BackColor = System.Drawing.SystemColors.Control;
			dataGridViewCellStyle1.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			dataGridViewCellStyle1.ForeColor = System.Drawing.SystemColors.WindowText;
			dataGridViewCellStyle1.SelectionBackColor = System.Drawing.SystemColors.Highlight;
			dataGridViewCellStyle1.SelectionForeColor = System.Drawing.SystemColors.HighlightText;
			dataGridViewCellStyle1.WrapMode = System.Windows.Forms.DataGridViewTriState.True;
			this.dgv_mensagens.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
			this.dgv_mensagens.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
			this.dgv_mensagens.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.Nome,
            this.Email,
            this.Mensagem,
            this.Data,
            this.Respondida});
			dataGridViewCellStyle2.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
			dataGridViewCellStyle2.BackColor = System.Drawing.SystemColors.Window;
			dataGridViewCellStyle2.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			dataGridViewCellStyle2.ForeColor = System.Drawing.Color.Black;
			dataGridViewCellStyle2.SelectionBackColor = System.Drawing.SystemColors.Highlight;
			dataGridViewCellStyle2.SelectionForeColor = System.Drawing.Color.White;
			dataGridViewCellStyle2.WrapMode = System.Windows.Forms.DataGridViewTriState.False;
			this.dgv_mensagens.DefaultCellStyle = dataGridViewCellStyle2;
			this.dgv_mensagens.Location = new System.Drawing.Point(5, 5);
			this.dgv_mensagens.Name = "dgv_mensagens";
			dataGridViewCellStyle3.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
			dataGridViewCellStyle3.BackColor = System.Drawing.SystemColors.Control;
			dataGridViewCellStyle3.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			dataGridViewCellStyle3.ForeColor = System.Drawing.SystemColors.WindowText;
			dataGridViewCellStyle3.SelectionBackColor = System.Drawing.SystemColors.Highlight;
			dataGridViewCellStyle3.SelectionForeColor = System.Drawing.SystemColors.HighlightText;
			dataGridViewCellStyle3.WrapMode = System.Windows.Forms.DataGridViewTriState.True;
			this.dgv_mensagens.RowHeadersDefaultCellStyle = dataGridViewCellStyle3;
			this.dgv_mensagens.RowHeadersWidthSizeMode = System.Windows.Forms.DataGridViewRowHeadersWidthSizeMode.AutoSizeToAllHeaders;
			this.dgv_mensagens.Size = new System.Drawing.Size(722, 405);
			this.dgv_mensagens.TabIndex = 0;
			// 
			// Nome
			// 
			this.Nome.HeaderText = "Nome";
			this.Nome.Name = "Nome";
			// 
			// Email
			// 
			this.Email.HeaderText = "Email";
			this.Email.Name = "Email";
			// 
			// Mensagem
			// 
			this.Mensagem.HeaderText = "Mensagem";
			this.Mensagem.Name = "Mensagem";
			// 
			// Data
			// 
			this.Data.HeaderText = "Data";
			this.Data.Name = "Data";
			// 
			// Respondida
			// 
			this.Respondida.HeaderText = "Respondida";
			this.Respondida.Name = "Respondida";
			// 
			// txt_search
			// 
			this.txt_search.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this.txt_search.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.txt_search.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.txt_search.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.txt_search.ForeColor = System.Drawing.Color.WhiteSmoke;
			this.txt_search.Location = new System.Drawing.Point(563, 21);
			this.txt_search.Name = "txt_search";
			this.txt_search.Size = new System.Drawing.Size(200, 27);
			this.txt_search.TabIndex = 23;
			// 
			// btn_search
			// 
			this.btn_search.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this.btn_search.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_search.FlatAppearance.BorderSize = 0;
			this.btn_search.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_search.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_search.ForeColor = System.Drawing.Color.White;
			this.btn_search.Location = new System.Drawing.Point(445, 21);
			this.btn_search.Name = "btn_search";
			this.btn_search.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_search.Size = new System.Drawing.Size(112, 27);
			this.btn_search.TabIndex = 24;
			this.btn_search.Text = "Pesquisar";
			this.btn_search.TextAlign = System.Drawing.ContentAlignment.TopLeft;
			this.btn_search.UseVisualStyleBackColor = true;
			this.btn_search.Click += new System.EventHandler(this.btn_search_Click);
			// 
			// pic_refresh
			// 
			this.pic_refresh.Cursor = System.Windows.Forms.Cursors.Hand;
			this.pic_refresh.Image = global::gymfit_app.Properties.Resources.refresh;
			this.pic_refresh.Location = new System.Drawing.Point(30, 21);
			this.pic_refresh.Name = "pic_refresh";
			this.pic_refresh.Size = new System.Drawing.Size(29, 25);
			this.pic_refresh.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this.pic_refresh.TabIndex = 25;
			this.pic_refresh.TabStop = false;
			this.pic_refresh.Click += new System.EventHandler(this.pic_refresh_Click);
			// 
			// uc_mensagens
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.Controls.Add(this.pic_refresh);
			this.Controls.Add(this.btn_search);
			this.Controls.Add(this.txt_search);
			this.Controls.Add(this.panel8);
			this.Name = "uc_mensagens";
			this.Size = new System.Drawing.Size(792, 511);
			this.Load += new System.EventHandler(this.uc_mensagens_Load);
			this.panel8.ResumeLayout(false);
			((System.ComponentModel.ISupportInitialize)(this.dgv_mensagens)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.pic_refresh)).EndInit();
			this.ResumeLayout(false);
			this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Panel panel8;
        private System.Windows.Forms.DataGridView dgv_mensagens;
        private System.Windows.Forms.DataGridViewTextBoxColumn Nome;
        private System.Windows.Forms.DataGridViewTextBoxColumn Email;
        private System.Windows.Forms.DataGridViewTextBoxColumn Mensagem;
        private System.Windows.Forms.DataGridViewTextBoxColumn Data;
        private System.Windows.Forms.DataGridViewTextBoxColumn Respondida;
        private System.Windows.Forms.TextBox txt_search;
        private System.Windows.Forms.Button btn_search;
        private System.Windows.Forms.PictureBox pic_refresh;
    }
}
