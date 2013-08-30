          </div>
        </div>

        <div id="sidebar">
          <?php
            get_sidebar('sidebar');
            get_sidebar('mobile');
          ?>
        </div>
      </div>
      <div id="footerbar" class="footerbar">
        <?php get_sidebar('footer'); ?>
      </div>
      <div id="footer">
        <?php wp_footer(); ?>
        <div id="copyright">Metallic Plain, Theme by PARMAJA. Valid XHTML 1.1 and CSS 3.</div>
      </div>
    </div>
  </body>
</html>