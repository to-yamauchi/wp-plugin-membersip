INSERT t_m_user_config 
set 
	p_code = %d, 
	m_code = %d, 
	s_code = %d, 
	value = %d, 
	valid_from = %s, 
	valid_to = %s
on duplicate key UPDATE
    p_code = %s
    and m_code = %d
    and s_code = %d
;