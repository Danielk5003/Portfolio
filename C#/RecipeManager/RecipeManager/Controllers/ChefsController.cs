using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Data.Entity.Infrastructure;
using System.Linq;
using System.Net;
using System.Net.Http;
using System.Threading.Tasks;
using System.Web.Http;
using System.Web.Http.Description;
using RecipeManager.Models;

namespace RecipeManager.Controllers
{
    public class ChefsController : ApiController
    {
        private RecipeManagerContext db = new RecipeManagerContext();

        // GET: api/Chefs
        public IQueryable<Chef> GetChefs()
        {
            return db.Chefs;
        }

        // GET: api/Chefs/5
        [ResponseType(typeof(Chef))]
        public async Task<IHttpActionResult> GetChef(int id)
        {
            Chef chef = await db.Chefs.FindAsync(id);
            if (chef == null)
            {
                return NotFound();
            }

            return Ok(chef);
        }

        // PUT: api/Chefs/5
        [ResponseType(typeof(void))]
        public async Task<IHttpActionResult> PutChef(int id, Chef chef)
        {
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            if (id != chef.Id)
            {
                return BadRequest();
            }

            db.Entry(chef).State = EntityState.Modified;

            try
            {
                await db.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!ChefExists(id))
                {
                    return NotFound();
                }
                else
                {
                    throw;
                }
            }

            return StatusCode(HttpStatusCode.NoContent);
        }

        // POST: api/Chefs
        [ResponseType(typeof(Chef))]
        public async Task<IHttpActionResult> PostChef(Chef chef)
        {
            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            db.Chefs.Add(chef);
            await db.SaveChangesAsync();

            return CreatedAtRoute("DefaultApi", new { id = chef.Id }, chef);
        }

        // DELETE: api/Chefs/5
        [ResponseType(typeof(Chef))]
        public async Task<IHttpActionResult> DeleteChef(int id)
        {
            Chef chef = await db.Chefs.FindAsync(id);
            if (chef == null)
            {
                return NotFound();
            }

            db.Chefs.Remove(chef);
            await db.SaveChangesAsync();

            return Ok(chef);
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                db.Dispose();
            }
            base.Dispose(disposing);
        }

        private bool ChefExists(int id)
        {
            return db.Chefs.Count(e => e.Id == id) > 0;
        }
    }
}