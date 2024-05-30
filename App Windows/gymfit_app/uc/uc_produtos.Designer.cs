namespace gymfit_app
{
    partial class uc_produtos
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
			System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle2 = new System.Windows.Forms.DataGridViewCellStyle();
			this.pic_refresh = new System.Windows.Forms.PictureBox();
			this.btn_search = new System.Windows.Forms.Button();
			this.txt_search = new System.Windows.Forms.TextBox();
			this.panel8 = new System.Windows.Forms.Panel();
			this.dgv_products = new System.Windows.Forms.DataGridView();
			this.Ref = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_name = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_desc = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_stock = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_marca = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_category = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.forn_price = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.pvp = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_sabor = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_tamanho = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_cor = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_peso = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_desconto = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_photos = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.prod_views = new System.Windows.Forms.DataGridViewTextBoxColumn();
			this.Vendido = new System.Windows.Forms.DataGridViewTextBoxColumn();
			((System.ComponentModel.ISupportInitialize)(this.pic_refresh)).BeginInit();
			this.panel8.SuspendLayout();
			((System.ComponentModel.ISupportInitialize)(this.dgv_products)).BeginInit();
			this.SuspendLayout();
			// 
			// pic_refresh
			// 
			this.pic_refresh.Cursor = System.Windows.Forms.Cursors.Hand;
			this.pic_refresh.Image = global::gymfit_app.Properties.Resources.refresh;
			this.pic_refresh.Location = new System.Drawing.Point(30, 21);
			this.pic_refresh.Name = "pic_refresh";
			this.pic_refresh.Size = new System.Drawing.Size(29, 25);
			this.pic_refresh.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this.pic_refresh.TabIndex = 29;
			this.pic_refresh.TabStop = false;
			this.pic_refresh.Click += new System.EventHandler(this.pic_refresh_Click);
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
			this.btn_search.TabIndex = 28;
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
			this.txt_search.Location = new System.Drawing.Point(563, 21);
			this.txt_search.Name = "txt_search";
			this.txt_search.Size = new System.Drawing.Size(200, 27);
			this.txt_search.TabIndex = 27;
			// 
			// panel8
			// 
			this.panel8.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.panel8.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(32)))), ((int)(((byte)(32)))), ((int)(((byte)(32)))));
			this.panel8.Controls.Add(this.dgv_products);
			this.panel8.Location = new System.Drawing.Point(30, 67);
			this.panel8.Name = "panel8";
			this.panel8.Size = new System.Drawing.Size(733, 416);
			this.panel8.TabIndex = 26;
			// 
			// dgv_products
			// 
			this.dgv_products.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.dgv_products.BackgroundColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.dgv_products.BorderStyle = System.Windows.Forms.BorderStyle.None;
			this.dgv_products.CellBorderStyle = System.Windows.Forms.DataGridViewCellBorderStyle.Raised;
			this.dgv_products.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.AutoSize;
			this.dgv_products.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.Ref,
            this.prod_name,
            this.prod_desc,
            this.prod_stock,
            this.prod_marca,
            this.prod_category,
            this.forn_price,
            this.pvp,
            this.prod_sabor,
            this.prod_tamanho,
            this.prod_cor,
            this.prod_peso,
            this.prod_desconto,
            this.prod_photos,
            this.prod_views,
            this.Vendido});
			dataGridViewCellStyle2.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleLeft;
			dataGridViewCellStyle2.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			dataGridViewCellStyle2.Font = new System.Drawing.Font("Century Gothic", 9.75F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			dataGridViewCellStyle2.ForeColor = System.Drawing.Color.White;
			dataGridViewCellStyle2.SelectionBackColor = System.Drawing.SystemColors.Highlight;
			dataGridViewCellStyle2.SelectionForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			dataGridViewCellStyle2.WrapMode = System.Windows.Forms.DataGridViewTriState.False;
			this.dgv_products.DefaultCellStyle = dataGridViewCellStyle2;
			this.dgv_products.GridColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.dgv_products.Location = new System.Drawing.Point(5, 5);
			this.dgv_products.Name = "dgv_products";
			this.dgv_products.Size = new System.Drawing.Size(722, 405);
			this.dgv_products.TabIndex = 0;
			// 
			// Ref
			// 
			this.Ref.HeaderText = "Ref";
			this.Ref.Name = "Ref";
			// 
			// prod_name
			// 
			this.prod_name.HeaderText = "Nome";
			this.prod_name.Name = "prod_name";
			// 
			// prod_desc
			// 
			this.prod_desc.HeaderText = "Descrição";
			this.prod_desc.Name = "prod_desc";
			// 
			// prod_stock
			// 
			this.prod_stock.HeaderText = "Stock";
			this.prod_stock.Name = "prod_stock";
			// 
			// prod_marca
			// 
			this.prod_marca.HeaderText = "Marca";
			this.prod_marca.Name = "prod_marca";
			// 
			// prod_category
			// 
			this.prod_category.HeaderText = "Categoria";
			this.prod_category.Name = "prod_category";
			// 
			// forn_price
			// 
			this.forn_price.HeaderText = "Preço fornecedor";
			this.forn_price.Name = "forn_price";
			// 
			// pvp
			// 
			this.pvp.HeaderText = "pvp";
			this.pvp.Name = "pvp";
			// 
			// prod_sabor
			// 
			this.prod_sabor.HeaderText = "Sabor";
			this.prod_sabor.Name = "prod_sabor";
			// 
			// prod_tamanho
			// 
			this.prod_tamanho.HeaderText = "Tamanho";
			this.prod_tamanho.Name = "prod_tamanho";
			// 
			// prod_cor
			// 
			this.prod_cor.HeaderText = "Cor";
			this.prod_cor.Name = "prod_cor";
			// 
			// prod_peso
			// 
			this.prod_peso.HeaderText = "Peso";
			this.prod_peso.Name = "prod_peso";
			// 
			// prod_desconto
			// 
			this.prod_desconto.HeaderText = "Desconto";
			this.prod_desconto.Name = "prod_desconto";
			// 
			// prod_photos
			// 
			this.prod_photos.HeaderText = "Fotos";
			this.prod_photos.Name = "prod_photos";
			// 
			// prod_views
			// 
			this.prod_views.HeaderText = "Visitas";
			this.prod_views.Name = "prod_views";
			// 
			// Vendido
			// 
			this.Vendido.HeaderText = "Vendido";
			this.Vendido.Name = "Vendido";
			// 
			// uc_produtos
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.Controls.Add(this.pic_refresh);
			this.Controls.Add(this.btn_search);
			this.Controls.Add(this.txt_search);
			this.Controls.Add(this.panel8);
			this.Name = "uc_produtos";
			this.Size = new System.Drawing.Size(792, 511);
			this.Load += new System.EventHandler(this.uc_produtos_Load);
			((System.ComponentModel.ISupportInitialize)(this.pic_refresh)).EndInit();
			this.panel8.ResumeLayout(false);
			((System.ComponentModel.ISupportInitialize)(this.dgv_products)).EndInit();
			this.ResumeLayout(false);
			this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.PictureBox pic_refresh;
        private System.Windows.Forms.Button btn_search;
        private System.Windows.Forms.TextBox txt_search;
        private System.Windows.Forms.Panel panel8;
        private System.Windows.Forms.DataGridView dgv_products;
		private System.Windows.Forms.DataGridViewTextBoxColumn Ref;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_name;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_desc;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_stock;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_marca;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_category;
		private System.Windows.Forms.DataGridViewTextBoxColumn forn_price;
		private System.Windows.Forms.DataGridViewTextBoxColumn pvp;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_sabor;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_tamanho;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_cor;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_peso;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_desconto;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_photos;
		private System.Windows.Forms.DataGridViewTextBoxColumn prod_views;
		private System.Windows.Forms.DataGridViewTextBoxColumn Vendido;
	}
}
