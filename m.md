| code |
|------|
|auto hash = Crypto::pbkdf2(password, salt, iter);|
| bool const_time_equal(const std::vector<unsigned char>& a, const std::vector<unsigned char>& b);  |
| 
std::string token = random_hex(24);
token_to_user[token] = username;
token_expiry[token] = std::time(nullptr) + 3600; 

if (u.failed_count >= MAX_FAILED_ATTEMPTS) {
    u.locked_until = std::time(nullptr) + LOCK_SECONDS; 
    |
