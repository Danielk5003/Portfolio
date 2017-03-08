namespace RecipeManager.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class Initial : DbMigration
    {
        public override void Up()
        {
            CreateTable(
                "dbo.Chefs",
                c => new
                    {
                        Id = c.Int(nullable: false, identity: true),
                        Name = c.String(nullable: false),
                    })
                .PrimaryKey(t => t.Id);
            
            CreateTable(
                "dbo.Recipes",
                c => new
                    {
                        Id = c.Int(nullable: false, identity: true),
                        Name = c.String(nullable: false),
                        Serves = c.Int(nullable: false),
                        Time = c.String(),
                        Ingredient = c.String(),
                        Instruction = c.String(),
                        ChefId = c.Int(nullable: false),
                    })
                .PrimaryKey(t => t.Id)
                .ForeignKey("dbo.Chefs", t => t.ChefId, cascadeDelete: true)
                .Index(t => t.ChefId);
            
        }
        
        public override void Down()
        {
            DropForeignKey("dbo.Recipes", "ChefId", "dbo.Chefs");
            DropIndex("dbo.Recipes", new[] { "ChefId" });
            DropTable("dbo.Recipes");
            DropTable("dbo.Chefs");
        }
    }
}
