<table border="1">
  <tr>
    <th>Code Snippet</th>
  </tr>
  <tr>
    <td>
      <pre>
auto hash = Crypto::pbkdf2(password, salt, iter);
      </pre>
    </td>
  </tr>
  <tr>
    <td>
      <pre>
bool const_time_equal(const std::vector&lt;unsigned char&gt;&amp; a, const std::vector&lt;unsigned char&gt;&amp; b);
      </pre>
    </td>
  </tr>
  <tr>
    <td>
      <pre>
std::string token = random_hex(24);
token_to_user[token] = username;
token_expiry[token] = std::time(nullptr) + 3600;

if (u.failed_count >= MAX_FAILED_ATTEMPTS) {
    u.locked_until = std::time(nullptr) + LOCK_SECONDS; 
}
      </pre>
    </td>
  </tr>
</table>
